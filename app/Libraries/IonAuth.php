<?php

namespace App\Libraries;

class IonAuth
{
	protected $config;
	protected $ionAuthModel;
	protected $email;
	public function __construct()
	{
		// Check compat first
		$this->config = config('IonAuth');
		$this->email = \Config\Services::email();
		helper('cookie');
		$this->session = session();
		$this->ionAuthModel = new \App\Models\IonAuthModel();
		$emailConfig = $this->config->emailConfig;
		if ($this->config->useCiEmail && isset($emailConfig) && is_array($emailConfig)) {
			$this->email->initialize($emailConfig);
		}
		$this->triggerEvents('library_constructor');
	}
	public function __call(string $method, array $arguments)
	{
		if (!method_exists($this->ionAuthModel, $method)) {
			throw new \Exception('Undefined method Ion_auth::' . $method . '() called');
		}
		if ($method === 'create_user') {
			return call_user_func_array([$this, 'register'], $arguments);
		}
		if ($method === 'update_user') {
			return call_user_func_array([$this, 'update'], $arguments);
		}
		return call_user_func_array([$this->ionAuthModel, $method], $arguments);
	}
	public function forgottenPassword(string $identity)
	{
		// Retrieve user information
		$user = $this->ionAuthModel->getUserFromIdentity($identity)
			->where('active', 1)
			->limit(1)
			->get()
			->getRow();
		if ($user) {
			// Generate code
			$code = $this->ionAuthModel->forgottenPassword($identity);
			if ($code) {
				$data = [
					'identity'              => $identity,
					'forgottenPasswordCode' => $code,
				];
				if (!$this->config->useCiEmail) {
					$this->setMessage('IonAuth.forgot_password_successful');
					return $data;
				} else {
					$message = view($this->config->emailTemplates . $this->config->emailForgotPassword, $data);
					$this->email->clear();
					$this->email->setFrom($this->config->adminEmail, $this->config->siteTitle);
					$this->email->setTo($user->email);
					$this->email->setSubject($this->config->siteTitle . ' - ' . lang('IonAuth.email_forgotten_password_subject'));
					$this->email->setMessage($message);
					if ($this->email->send()) {
						$this->setMessage('IonAuth.forgot_password_successful');
						return true;
					}
					//$this->setError($this->email->printDebugger(['headers', 'subject', 'body']));
				}
			}
		}
		$this->setError('IonAuth.forgot_password_unsuccessful');
		return false;
	}
	public function forgottenPasswordCheck(string $code)
	{
		$user = $this->ionAuthModel->getUserByForgottenPasswordCode($code);
		if (!is_object($user)) {
			$this->setError('IonAuth.password_change_unsuccessful');
			return false;
		} else {
			if ($this->config->forgotPasswordExpiration > 0) {
				//Make sure it isn't expired
				$expiration = $this->config->forgotPasswordExpiration;
				if (time() - $user->forgotten_password_time > $expiration) {
					//it has expired
					$identity = $user->{$this->config->identity};
					$this->ionAuthModel->clearForgottenPasswordCode($identity);
					$this->setError('IonAuth.password_change_unsuccessful');
					return false;
				}
			}
			return $user;
		}
	}
	public function register(string $identity, string $password, string $email, array $additionalData = [], array $groupIds = [], $checkEmail = false)
	{
		$this->triggerEvents('pre_account_creation');

		if (!$checkEmail) {
			$emailActivation = false;
		}else{
			$emailActivation = $this->config->emailActivation;
		}
		$id = $this->ionAuthModel->register($identity, $password, $email, $additionalData, $groupIds);

		if (!$emailActivation) {
			if ($id !== false) {
				$this->setMessage('IonAuth.account_creation_successful');
				$this->triggerEvents(['post_account_creation', 'post_account_creation_successful']);
				return $id;
			} else {
				$this->setError('IonAuth.account_creation_unsuccessful');
				$this->triggerEvents(['post_account_creation', 'post_account_creation_unsuccessful']);
				return false;
			}
		} else {
			if (!$id) {
				$this->setError('IonAuth.account_creation_unsuccessful');
				return false;
			}
			// deactivate so the user must follow the activation flow
			$deactivate = $this->ionAuthModel->deactivate($id);
			// the deactivate method call adds a message, here we need to clear that
			$this->clearMessages();
			if (!$deactivate) {
				$this->setError('IonAuth.deactivate_unsuccessful');
				$this->triggerEvents(['post_account_creation', 'post_account_creation_unsuccessful']);
				return false;
			}
			$activationCode = $this->ionAuthModel->activationCode;
			$identity       = $this->config->identity;
			$user           = $this->ionAuthModel->user($id);
			$data = [
				'identity'   => $user->{$identity},
				'id'         => $user->id,
				'email'      => $email,
				'activation' => $activationCode,
			];
			if (!$this->config->useCiEmail) {
				$this->triggerEvents(['post_account_creation', 'post_account_creation_successful', 'activation_email_successful']);
				$this->setMessage('IonAuth.activation_email_successful');
				return $data;
			} else {
				$message = view($this->config->emailTemplates . $this->config->emailActivate, $data);

				$this->email->clear();
				$this->email->setFrom($this->config->adminEmail, $this->config->siteTitle);
				$this->email->setTo($email);
				$this->email->setSubject($this->config->siteTitle . ' - ' . lang('IonAuth.emailActivation_subject'));
				$this->email->setMessage($message);

				if ($this->email->send() === true) {
					$this->triggerEvents(['post_account_creation', 'post_account_creation_successful', 'activation_email_successful']);
					$this->setMessage('IonAuth.activation_email_successful');
					return $id;
				}
			}
			$this->triggerEvents(['post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful']);
			$this->setError('IonAuth.activation_email_unsuccessful');
			return false;
		}
	}
	public function logout(): bool
	{
		$this->triggerEvents('logout');

		$identity = $this->session->get('user_id');
		$this->session->remove([$identity, 'id', 'user_id']);
		// delete the remember me cookies if they exist
		delete_cookie($this->config->rememberCookieName);
		// Clear all codes
		if (isset($identity)) {
			$this->ionAuthModel->clearForgottenPasswordCode($identity);
			$this->ionAuthModel->clearRememberCode($identity);
		}
		// Destroy the session
		$this->session->destroy();
		// Recreate the session
		session_start();
		session_regenerate_id(true);
		$this->setMessage('IonAuth.logout_successful');
		return true;
	}
	public function loggedIn(): bool
	{
		$this->triggerEvents('logged_in');

		$recheck = $this->ionAuthModel->recheckSession();
		// auto-login the user if they are remembered
		if (!$recheck && get_cookie($this->config->rememberCookieName)) {
			$recheck = $this->ionAuthModel->loginRememberedUser();
		}
		return $recheck;
	}
	public function getUserId()
	{
		$userId = $this->session->get('user_id');
		if (!empty($userId)) {
			return $userId;
		}
		return null;
	}
	public function isAdmin(int $id = 0): bool
	{
		$this->triggerEvents('is_admin');
		$adminGroup = $this->config->adminGroup;
		return $this->loggedIn() && $this->ionAuthModel->inGroup($adminGroup, $id);
	}
}
