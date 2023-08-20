<?php

namespace App\Models;

use \CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Debug\Toolbar\Collectors\Events;

class IonAuthModel
{
	/**
	 * Max cookie lifetime constant
	 */
	const MAX_COOKIE_LIFETIME = 15552000; // 2 years = 60*60*24*365*2 = 63072000 seconds;

	/**
	 * Max password size constant
	 */
	const MAX_PASSWORD_SIZE_BYTES = 4096;

	protected $config, $join, $hashMethod, $messagesTemplates;
	protected $session;
	protected $cacheUserInGroup = [];
	protected $cacheGroups = [];
	protected $db;
	protected $response = null;
	protected $ionHooks;

	public $tables = [];
	public $activationCode;
	public $identityColumn;
	public $events;

	protected $messages = [];
	protected $errors = [];
	protected $messageTemplates = [];

	public function __construct()
	{
		$this->config = config('IonAuth');
		helper(['cookie', 'date']);
		$this->session = session();
		$this->ionHooks = new \stdClass();

		// initialize the database
		if (empty($this->config->databaseGroupName)) {
			// By default, use CI's db that should be already loaded
			$this->db = \Config\Database::connect();
		} else {
			// For specific group name, open a new specific connection
			$this->db = \Config\Database::connect($this->config->databaseGroupName);
		}

		// initialize db tables data
		$this->tables = $this->config->tables;

		// initialize data
		$this->identityColumn = $this->config->identity;
		$this->join           = $this->config->join;

		// initialize hash method options (Bcrypt)
		$this->hashMethod = $this->config->hashMethod;
		$this->triggerEvents('model_constructor');
		$this->messagesTemplates = $this->config->templates['messages'];
	}
	public function db()
	{
		return $this->db;
	}
	//Password
	public function hashPassword(string $password, string $identity = '')
	{

		if (empty($password) || strpos($password, "\0") !== false || strlen($password) > self::MAX_PASSWORD_SIZE_BYTES) {
			return false;
		}
		$algo   = $this->getHashAlgo();
		$params = $this->getHashParameters($identity);
		if ($algo !== false && $params !== false) {
			return password_hash($password, $algo, $params);
		}
		return false;
	}
	protected function getHashAlgo()
	{
		$algo = false;
		switch ($this->hashMethod) {
			case 'bcrypt':
				$algo = PASSWORD_BCRYPT;
				break;
			case 'argon2':
				$algo = PASSWORD_ARGON2I;
				break;
			default:
				// Do nothing
		}
		return $algo;
	}
	protected function getHashParameters(string $identity = '')
	{
		// Check if user is administrator or not
		$isAdmin = false;
		if ($identity) {
			$userId = $this->getUserFromIdentity($identity)->limit(1)->get()->getRow()->id;
			if ($userId && $this->inGroup($this->config->adminGroup, $userId)) {
				$isAdmin = true;
			}
		}
		$params = false;
		switch ($this->hashMethod) {
			case 'bcrypt':
				$params = ['cost' => $isAdmin ? $this->config->bcryptAdminCost : $this->config->bcryptDefaultCost];
				break;
			case 'argon2':
				$params = $isAdmin ? $this->config->argon2AdminParams : $this->config->argon2DefaultParams;
				break;
			default:
				// Do nothing
		}
		return $params;
	}
	public function rehashPasswordIfNeeded(string $hash, string $identity, string $password): void
	{
		$algo   = $this->getHashAlgo();
		$params = $this->getHashParameters($identity);

		if ($algo !== false && $params !== false) {
			if (password_needs_rehash($hash, $algo, $params)) {
				if ($this->setPasswordDb($identity, $password)) {
					$this->triggerEvents(['rehash_password', 'rehash_password_successful']);
				} else {
					$this->triggerEvents(['rehash_password', 'rehash_password_unsuccessful']);
				}
			}
		}
	}
	protected function setPasswordDb(string $identity, string $password): bool
	{
		$hash = $this->hashPassword($password, $identity);
		if ($hash === false) {
			return false;
		}
		// When setting a new password, invalidate any other token
		$data = [
			'password'                => $hash,
			'remember_code'           => null,
			'forgotten_password_code' => null,
			'forgotten_password_time' => null,
		];
		$this->triggerEvents('extra_where');
		$this->db->table($this->tables['users'])->update($data, [$this->identityColumn => $identity]);
		return $this->db->affectedRows() === 1;
	}
	public function forgottenPassword(string $identity)
	{
		if (empty($identity)) {
			return false;
		}
		// Generate random token: smaller size because it will be in the URL
		$token = $this->generateSelectorValidatorCouple(20, 80);
		$update = [
			'forgotten_password_selector' => $token->selector,
			'forgotten_password_code'     => $token->validatorHashed,
			'forgotten_password_time'     => time(),
		];
		$this->db->table($this->tables['users'])->update($update, [$this->identityColumn => $identity]);
		if ($this->db->affectedRows() === 1) {
			return $token->userCode;
		} else {
			return false;
		}
	}
	public function clearForgottenPasswordCode(string $identity): bool
	{
		if (empty($identity)) {
			return false;
		}

		$data = [
			'forgotten_password_selector' => null,
			'forgotten_password_code'     => null,
			'forgotten_password_time'     => null,
		];

		return $this->db->table($this->tables['users'])->where($this->identityColumn, $identity)->update($data);
	}
	public function clearRememberCode(string $identity): bool
	{
		if (empty($identity)) {
			return false;
		}

		$data = [
			'remember_selector' => null,
			'remember_code'     => null,
		];

		return $this->db->table($this->tables['users'])->where($this->identityColumn, $identity)->update($data);
	}
	public function verifyPassword(string $password, string $hashPasswordDb, string $identity = ''): bool
	{
		// Check for empty id or password, or password containing null char, or password above limit
		// Null char may pose issue: http://php.net/manual/en/function.password-hash.php#118603
		// Long password may pose DOS issue (note: strlen gives size in bytes and not in multibyte symbol)
		if (
			empty($password) || empty($hashPasswordDb) || strpos($password, "\0") !== false
			|| strlen($password) > self::MAX_PASSWORD_SIZE_BYTES
		) {
			return false;
		}

		return password_verify($password, $hashPasswordDb);
	}
	public function resetPassword(string $identity, string $new)
	{
		$this->triggerEvents('pre_change_password');

		if (!$this->identityCheck($identity)) {
			$this->triggerEvents(['post_change_password', 'post_change_password_unsuccessful']);
			return false;
		}

		$return = $this->setPasswordDb($identity, $new);

		if ($return) {
			$this->triggerEvents(['post_change_password', 'post_change_password_successful']);
			$this->setMessage('IonAuth.password_change_successful');
		} else {
			$this->triggerEvents(['post_change_password', 'post_change_password_unsuccessful']);
			$this->setError('IonAuth.password_change_unsuccessful');
		}
		return $return;
	}
	public function changePassword(string $identity, string $old, string $new): bool
	{
		$this->triggerEvents('pre_change_password');
		$this->triggerEvents('extra_where');
		$builder = $this->db->table($this->tables['users']);
		$query   = $builder
			->select('id, password')
			->where($this->identityColumn, $identity)
			->limit(1)
			->get()->getResult();

		if (empty($query)) {
			$this->triggerEvents(['post_change_password', 'post_change_password_unsuccessful']);
			$this->setError('IonAuth.password_change_unsuccessful');
			return false;
		}
		$user = $query[0];
		if ($this->verifyPassword($old, $user->password, $identity)) {
			$result = $this->setPasswordDb($identity, $new);
			if ($result) {
				$this->triggerEvents(['post_change_password', 'post_change_password_successful']);
				$this->setMessage('IonAuth.password_change_successful');
			} else {
				$this->triggerEvents(['post_change_password', 'post_change_password_unsuccessful']);
				$this->setError('IonAuth.password_change_unsuccessful');
			}
			return $result;
		}

		$this->setError('IonAuth.password_change_unsuccessful');
		return false;
	}
	//log in
	public function login(string $identity, string $password, bool $remember = false): bool
	{
		$this->triggerEvents('pre_login');
		if (empty($identity) || empty($password)) {
			$this->setError('IonAuth.login_unsuccessful');
			return false;
		}
		$this->triggerEvents('extra_where');
		$query = $this->db->table($this->tables['users'])
			->select($this->identityColumn . ', nama_user, email, users.id as id, password, active, last_login, img, groups.`name` as group_name, groups.id as group_id, id_peg')
			->join('users_groups', 'users_groups.user_id = users.id')
			->join('groups', 'users_groups.group_id = groups.id')
			->where($this->identityColumn, $identity)
			->limit(1)
			->orderBy('id', 'desc')
			->get();

		if ($this->isMaxLoginAttemptsExceeded($identity)) {
			// Hash something anyway, just to take up time
			$this->hashPassword($password);
			$this->triggerEvents('post_login_unsuccessful');
			$this->setError('IonAuth.login_timeout');
			return false;
		}
		$user = $query->getRow();
		if (isset($user)) {
			if ($this->verifyPassword($password, $user->password, $identity)) {
				if ($user->active == 0) {
					$this->triggerEvents('post_login_unsuccessful');
					$this->setError('IonAuth.login_unsuccessful_not_active');
					return false;
				}
				$this->setSession($user);
				$this->updateLastLogin($user->id);
				$this->clearLoginAttempts($identity);
				$this->clearForgottenPasswordCode($identity);
				if ($this->config->rememberUsers) {
					if ($remember) {
						$this->rememberUser($identity);
					} else {
						$this->clearRememberCode($identity);
					}
				}
				// Rehash if needed
				$this->rehashPasswordIfNeeded($user->password, $identity, $password);
				// Regenerate the session (for security purpose: to avoid session fixation)
				$this->session->regenerate(false);
				$this->triggerEvents(['post_login', 'post_login_successful']);
				$this->setMessage('IonAuth.login_successful');
				return true;
			}
		}
		// Hash something anyway, just to take up time
		$this->hashPassword($password);
		$this->increaseLoginAttempts($identity);
		$this->triggerEvents('post_login_unsuccessful');
		$this->setError('IonAuth.login_unsuccessful');
		return false;
	}
	public function loginApi(string $identity, string $password)
	{
		$this->triggerEvents('pre_login');
		if (empty($identity) || empty($password)) {
			$this->setError('IonAuth.login_unsuccessful');
			return false;
		}
		$this->triggerEvents('extra_where');
		$query = $this->db->table($this->tables['users'])
			->select('username , nama_user, email, users.id as id, password, active, last_login, img, id_peg, device_id, user_agent')
			->where($this->identityColumn, $identity)
			->limit(1)
			->orderBy('id', 'desc')
			->get();

		$user = $query->getRow();
		if (isset($user)) {
			if ($this->verifyPassword($password, $user->password, $identity)) {
				if ($user->active == 0) {
					$this->triggerEvents('post_login_unsuccessful');
					$this->setError('IonAuth.login_unsuccessful_not_active');
					return false;
				}
				$this->updateLastLogin($user->id);
				$this->clearLoginAttempts($identity);
				$this->clearForgottenPasswordCode($identity);
				// Rehash if needed
				$this->rehashPasswordIfNeeded($user->password, $identity, $password);
				// Regenerate the session (for security purpose: to avoid session fixation)
				$this->session->regenerate(false);
				$this->triggerEvents(['post_login', 'post_login_successful']);
				$this->setMessage('IonAuth.login_successful');
				return $user;
			}
		}
		// Hash something anyway, just to take up time
		$this->hashPassword($password);
		$this->triggerEvents('post_login_unsuccessful');
		$this->setError('IonAuth.login_unsuccessful');
		return false;
	}
	public function isMaxLoginAttemptsExceeded(string $identity, $ipAddress = null): bool
	{
		if ($this->config->trackLoginAttempts) {
			$maxAttempts = $this->config->maximumLoginAttempts;
			if ($maxAttempts > 0) {
				$attempts = $this->getAttemptsNum($identity, $ipAddress);
				return $attempts >= $maxAttempts;
			}
		}
		return false;
	}
	public function getAttemptsNum(string $identity, $ipAddress = null): int
	{
		if ($this->config->trackLoginAttempts) {
			$builder = $this->db->table($this->tables['login_attempts']);
			$builder->where('login', $identity);
			if ($this->config->trackLoginIpAddress) {
				if (!isset($ipAddress)) {
					$ipAddress = \Config\Services::request()->getIPAddress();
				}
				$builder->where('ip_address', $ipAddress);
			}
			$builder->where('time >', time() - $this->config->lockoutTime, false);
			return $builder->countAllResults();
		}
		return 0;
	}
	public function clearLoginAttempts(string $identity, int $oldAttemptsAxpirePeriod = 86400, $ipAddress = null): bool
	{
		if ($this->config->trackLoginAttempts) {
			// Make sure $oldAttemptsAxpirePeriod is at least equals to lockoutTime
			$oldAttemptsAxpirePeriod = max($oldAttemptsAxpirePeriod, $this->config->lockoutTime);

			$builder = $this->db->table($this->tables['login_attempts']);
			$builder->where('login', $identity);
			if ($this->config->trackLoginIpAddress) {
				if (!isset($ipAddress)) {
					$ipAddress = \Config\Services::request()->getIPAddress();
				}
				$builder->where('ip_address', $ipAddress);
			}
			// Purge obsolete login attempts
			$builder->orWhere('time <', time() - $oldAttemptsAxpirePeriod, false);
			return $builder->delete() === false ? false : true;
		}
		return false;
	}
	public function increaseLoginAttempts(string $identity): bool
	{
		if ($this->config->trackLoginAttempts) {
			$data = ['ip_address' => '', 'login' => $identity, 'time' => time()];
			if ($this->config->trackLoginIpAddress) {
				$data['ip_address'] = \Config\Services::request()->getIPAddress();
			}
			$builder = $this->db->table($this->tables['login_attempts']);
			$builder->insert($data);
			return true;
		}
		return false;
	}
	public function updateLastLogin(int $id): bool
	{
		$this->triggerEvents('update_last_login');
		$this->triggerEvents('extra_where');
		$this->db->table($this->tables['users'])->update(['last_login' => time()], ['id' => $id]);
		return $this->db->affectedRows() === 1;
	}
	//session
	public function setSession(\stdClass $user): bool
	{
		$this->triggerEvents('pre_set_session');
		$sessionData = [
			'identity'            => $user->{$this->identityColumn},
			$this->identityColumn => $user->{$this->identityColumn},
			'email'               => $user->email,
			'nama_user'           => $user->nama_user,
			'userlevel'           => $user->group_name,
			'userLevelId'         => $user->group_id,
			'user_id'             => $user->id, //everyone likes to overwrite id so we'll use user_id
			'id_peg'              => $user->id_peg !== null ? $user->id_peg : '', //everyone likes to overwrite id so we'll use user_id
			'old_last_login'      => date('d-M-Y H:i:s', $user->last_login),
			'last_check'          => time(),
			'thumb'       		  => ($user->img != '') ? (file_exists(base_url("thumb/$user->img")) ? base_url("thumb/$user->img") : base_url('/assets/dist/img/profile.jpg')) : base_url('/assets/dist/img/profile.jpg'),
			'full'       		  => ($user->img != '') ? (file_exists(base_url("full/$user->img")) ? base_url("full/$user->img") : base_url('/assets/dist/img/profile.jpg')) : base_url('/assets/dist/img/profile.jpg')
		];
		$this->session->set($sessionData);
		$this->triggerEvents('post_set_session');
		return true;
	}
	public function recheckSession(): bool
	{
		$recheck = (null !== $this->config->recheckTimer) ? $this->config->recheckTimer : 0;
		if ($recheck !== 0) {
			$lastLogin = $this->session->get('last_check');
			if ($lastLogin + $recheck < time()) {
				$query = $this->db->table($this->tables['users']);
				$query->select('id')->where([
					$this->identityColumn => $this->session->get('identity'),
					'active'              => '1',
				])->limit(1)->orderBy('id', 'desc')->get();
				if ($query->countAllResults() === 1) {
					$this->session->set('last_check', time());
				} else {
					$this->triggerEvents('logout');
					$identity = $this->config->identity;
					$this->session->remove([$identity, 'id', 'user_id']);
					return false;
				}
			}
		}
		return (bool)session('identity');
	}
	//User
	public function getUserByForgottenPasswordCode(string $userCode)
	{
		// Retrieve the token object from the code
		$token = $this->retrieveSelectorValidatorCouple($userCode);

		// Retrieve the user according to this selector
		$builder = $this->db->table($this->tables['users'])->where('forgotten_password_selector', $token->selector)->get()->getRow();
		if ($builder) {
			// Check the hash against the validator
			if ($this->verifyPassword($token->validator, $builder->forgotten_password_code)) {
				return $builder;
			}
		}

		return false;
	}
	public function loginRememberedUser(): bool
	{
		$this->triggerEvents('pre_login_remembered_user');

		// Retrieve token from cookie
		$rememberCookie = get_cookie($this->config->rememberCookieName);
		$token          = $this->retrieveSelectorValidatorCouple($rememberCookie);

		if ($token === false) {
			$this->triggerEvents(['post_login_remembered_user', 'post_login_remembered_user_unsuccessful']);
			return false;
		}
		// get the user with the selector
		$this->triggerEvents('extra_where');
		$query = $this->db->table($this->tables['users'])
			->select($this->identityColumn . ', id, email, remember_code, last_login')
			->where('remember_selector', $token->selector)
			->where('active', 1)
			->limit(1);

		// Check that we got the user
		if ($query->countAllResults(false) === 1) {
			// Retrieve the information
			$user = $query->get()->getRow();

			// Check the code against the validator
			$identity = $user->{$this->identityColumn};
			if ($this->verifyPassword($token->validator, $user->remember_code, $identity)) {
				$this->updateLastLogin($user->id);

				$this->setSession($user);

				$this->clearForgottenPasswordCode($identity);

				// extend the users cookies if the option is enabled
				if ($this->config->userExtendonLogin) {
					$this->rememberUser($identity);
				}
				// Regenerate the session (for security purpose: to avoid session fixation)
				$this->session->regenerate(false);

				$this->triggerEvents(['post_login_remembered_user', 'post_login_remembered_user_successful']);
				return true;
			}
		}
		delete_cookie($this->config->rememberCookieName);

		$this->triggerEvents(['post_login_remembered_user', 'post_login_remembered_user_unsuccessful']);
		return false;
	}
	public function rememberUser(string $identity): bool
	{
		$this->triggerEvents('pre_remember_user');

		if (!$identity) {
			return false;
		}
		// Generate random tokens
		$token = $this->generateSelectorValidatorCouple();
		if ($token->validatorHashed) {
			$this->db->table($this->tables['users'])->update(
				[
					'remember_selector' => $token->selector,
					'remember_code' => $token->validatorHashed
				],
				[$this->identityColumn => $identity]
			);
			if ($this->db->affectedRows() > -1) {
				// if the userExpire is set to zero we'll set the expiration two years from now.
				if ($this->config->userExpire === 0) {
					$expire = self::MAX_COOKIE_LIFETIME;
				}
				// otherwise use what is set
				else {
					$expire = $this->config->userExpire;
				}
				set_cookie([
					'name'   => $this->config->rememberCookieName,
					'value'  => $token->userCode,
					'expire' => $expire
				]);
				$this->triggerEvents(['post_remember_user', 'remember_user_successful']);
				return true;
			}
		}
		$this->triggerEvents(['post_remember_user', 'remember_user_unsuccessful']);
		return false;
	}
	public function identityCheck(string $identity = ''): bool
	{
		$this->triggerEvents('identity_check');
		if (empty($identity)) {
			return false;
		}
		$builder = $this->db->table($this->tables['users']);
		return $builder->where($this->identityColumn, $identity)
			->limit(1)
			->countAllResults() > 0;
	}
	public function getUserFromIdentity(string $identity = '')
	{
		if (empty($identity)) {
			return false;
		}
		$user = $this->db->table($this->tables['users']);
		$user->select('id,email')->where($this->identityColumn, $identity);
		if ($user) {
			return $user;
		}
		return false;
	}
	public function getUserByActivationCode(string $userCode)
	{
		// Retrieve the token object from the code
		$token = $this->retrieveSelectorValidatorCouple($userCode);

		// Retrieve the user according to this selector
		$user = $this->db->table($this->tables['users'])->where('activation_selector', $token->selector)->get()->getRow();

		if ($user) {
			// Check the hash against the validator
			if ($this->verifyPassword($token->validator, $user->activation_code)) {
				return $user;
			}
		}
		return false;
	}
	public function users()
	{
		$this->triggerEvents('users');
		$builder = $this->db->table($this->tables['users']);
		return $builder->get()->getResult();
	}
	public function user(int $id = 0)
	{
		$this->triggerEvents('user');
		$id = $id ?: $this->session->get('user_id');

		$builder = $this->db->table($this->tables['users']);
		$builder->where('id', $id);
		return $builder->get()->getRow();
	}
	public function _get_datatables()
	{
		$this->triggerEvents('_get_datatables');
		$column_search = array('nama_user', 'username', 'email');
		$builder = $this->db->table($this->tables['users']);
		$i = 0;
		foreach ($column_search as $item) { // loop column 
			if ($_GET['search']) {
				if ($i === 0) {
					$builder->groupStart();
					$builder->like($item, $_GET['search']);
				} else {
					$builder->orLike($item, $_GET['search']);
				}
				if (count($column_search) - 1 == $i)
					$builder->groupEnd();
			}
			$i++;
		}
		if (isset($_GET['order'])) {
			$builder->orderBy($_GET['sort'], $_GET['order']);
		} else {
			$builder->orderBy('id', 'asc');
		}
		// $builder->where('skpd_id', session('skpd_id'));

		if ($_GET['limit'] != -1) $builder->limit($_GET['limit'], $_GET['offset']);
		return $builder;
	}
	public function get_datatables()
	{
		$this->triggerEvents('get_datatables');
		$builder = $this->_get_datatables();
		return $builder->get()->getResult();
	}
	public function count_filtered()
	{
		$this->triggerEvents('count_filtered');
		$builder = $this->_get_datatables();
		return $builder->countAllResults();
	}
	public function count_all()
	{
		$this->triggerEvents('count_all');
		$builder = $this->_get_datatables();
		return $builder->countAllResults();
	}
	//Group
	public function groups()
	{
		$this->triggerEvents('groups');

		$builder = $this->db->table($this->tables['groups']);
		return $builder->get()->getResult();
	}
	public function group(int $id = 0)
	{
		$this->triggerEvents('group');

		$builder = $this->db->table($this->tables['groups']);
		$builder->where('id', $id);
		return $builder->get()->getRow();
	}
	public function inGroup($checkGroup, int $id = 0, bool $checkAll = false): bool
	{
		$this->triggerEvents('in_group');

		$id || $id = $this->session->get('user_id');
		if (!is_array($checkGroup)) {
			$checkGroup = [$checkGroup];
		}
		if (isset($this->cacheUserInGroup[$id])) {
			$groupsArray = $this->cacheUserInGroup[$id];
		} else {
			$usersGroups = $this->getUsersGroups($id)->getResult();
			$groupsArray = [];
			foreach ($usersGroups as $group) {
				$groupsArray[$group->id] = $group->name;
			}
			$this->cacheUserInGroup[$id] = $groupsArray;
		}
		foreach ($checkGroup as $key => $value) {
			$groups = (is_numeric($value)) ? array_keys($groupsArray) : $groupsArray;
			if (in_array($value, $groups) xor $checkAll) {
				return !$checkAll;
			}
		}
		return $checkAll;
	}
	public function getUsersGroups(int $id = 0)
	{
		$this->triggerEvents('get_users_group');

		$id || $id = $this->session->get('user_id');

		$builder = $this->db->table($this->tables['users_groups']);
		return $builder->select($this->tables['users_groups'] . '.' . $this->join['groups'] . ' as id, ' . $this->tables['groups'] . '.name, ' . $this->tables['groups'] . '.description')
			->where($this->tables['users_groups'] . '.' . $this->join['users'], $id)
			->join($this->tables['groups'], $this->tables['users_groups'] . '.' . $this->join['groups'] . '=' . $this->tables['groups'] . '.id')
			->get();
	}
	public function addToGroup($groupIds, int $userId = 0): int
	{
		$this->triggerEvents('add_to_group');

		// if no id was passed use the current users id
		$userId || $userId = $this->session->get('user_id');
		if (!is_array($groupIds)) {
			$groupIds = [$groupIds];
		}
		$return = 0;
		// Then insert each into the database
		foreach ($groupIds as $groupId) {
			// Cast to float to support bigint data type
			if ($this->db->table($this->tables['users_groups'])->insert([$this->join['groups'] => (float)$groupId, $this->join['users']  => (float)$userId])) {
				if (isset($this->cacheGroups[$groupId])) {
					$groupName = $this->cacheGroups[$groupId];
				} else {
					$group                       = $this->group($groupId);
					$groupName                   = $group->name;
					$this->cacheGroups[$groupId] = $groupName;
				}
				$this->cacheUserInGroup[$userId][$groupId] = $groupName;
				// Return the number of groups added
				$return++;
			}
		}
		return $return;
	}
	public function removeFromGroup($groupIds = 0, int $userId = 0): bool
	{
		$this->triggerEvents('remove_from_group');

		if (!$userId) {
			return false;
		}
		$builder = $this->db->table($this->tables['users_groups']);
		// if group id(s) are passed remove user from the group(s)
		if (!empty($groupIds)) {
			if (!is_array($groupIds)) {
				$groupIds = [$groupIds];
			}
			foreach ($groupIds as $groupId) {
				$builder->delete([$this->join['groups'] => (int)$groupId, $this->join['users'] => $userId]);
				if (isset($this->cacheUserInGroup[$userId]) && isset($this->cacheUserInGroup[$userId][$groupId])) {
					unset($this->cacheUserInGroup[$userId][$groupId]);
				}
			}
			$return = true;
		} else { // otherwise remove user from all groups
			if ($return = $builder->delete([$this->join['users'] => $userId])) {
				$this->cacheUserInGroup[$userId] = [];
				$return = true;
			}
		}
		return $return;
	}
	//CUD
	public function register(string $identity, string $password, string $email, array $additionalData = [], array $groups = [])
	{
		$manualActivation = $this->config->manualActivation;
		if ($this->identityCheck($identity)) {
			$this->setError('IonAuth.account_creation_duplicate_identity');
			return false;
		} else if (!$this->config->defaultGroup && empty($groups)) {
			$this->setError('IonAuth.account_creation_missing_defaultGroup');
			return false;
		}
		// check if the default set in config exists in database
		$query = $this->db->table($this->tables['groups'])->where(['name' => $this->config->defaultGroup], 1)->get()->getRow();
		if (!isset($query->id) && empty($groups)) {
			$this->setError('IonAuth.account_creation_invalid_defaultGroup');
			return false;
		}
		// capture default group details
		$defaultGroup = $query;
		// IP Address
		$ipAddress = \Config\Services::request()->getIPAddress();

		// Do not pass $identity as user is not known yet so there is no need
		$password = $this->hashPassword($password);
		if ($password === false) {
			$this->setError('IonAuth.account_creation_unsuccessful');
			return false;
		}
		// Users table.
		$data = [
			$this->identityColumn => $identity,
			'username'            => $identity,
			'password'            => $password,
			'email'               => $email,
			'ip_address'          => $ipAddress,
			'created_on'          => time(),
			'active'              => ($manualActivation === false ? 1 : 0),
		];
		// filter out any data passed that doesnt have a matching column in the users table
		// and merge the set user data and the additional data
		$userData = array_merge($this->filterData($this->tables['users'], $additionalData), $data);

		$this->db->table($this->tables['users'])->insert($userData);

		$id = $this->db->insertId($this->tables['users'] . '_id_seq');

		// add in groups array if it doesn't exists and stop adding into default group if default group ids are set
		if (isset($defaultGroup->id) && empty($groups)) {
			$groups[] = $defaultGroup->id;
		}

		if (!empty($groups)) {
			// add to groups
			foreach ($groups as $group) {
				$this->addToGroup($group, $id);
			}
		}
		return $id ?? false;
	}
	public function update(int $id, array $data): bool
	{
		$this->triggerEvents('pre_update_user');

		$user = $this->user($id);

		$this->db->transBegin();

		if (array_key_exists($this->identityColumn, $data) && $this->identityCheck($data[$this->identityColumn]) && $user->{$this->identityColumn} !== $data[$this->identityColumn]) {
			$this->db->transRollback();
			$this->setError('IonAuth.account_creation_duplicate_identity');

			$this->triggerEvents(['post_update_user', 'post_update_user_unsuccessful']);
			$this->setError('IonAuth.update_unsuccessful');

			return false;
		}

		// Filter the data passed
		$data = $this->filterData($this->tables['users'], $data);

		if (array_key_exists($this->identityColumn, $data) || array_key_exists('password', $data) || array_key_exists('email', $data)) {
			if (array_key_exists('password', $data)) {
				if (!empty($data['password'])) {
					$data['password'] = $this->hashPassword($data['password'], $user->{$this->identityColumn});
					if ($data['password'] === false) {
						$this->db->transRollback();
						$this->triggerEvents(['post_update_user', 'post_update_user_unsuccessful']);
						$this->setError('IonAuth.update_unsuccessful');

						return false;
					}
				} else {
					// unset password so it doesn't effect database entry if no password passed
					unset($data['password']);
				}
			}
		}

		$this->triggerEvents('extra_where');
		$this->db->table($this->tables['users'])->update($data, ['id' => $user->id]);

		if ($this->db->transStatus() === false) {
			$this->db->transRollback();

			$this->triggerEvents(['post_update_user', 'post_update_user_unsuccessful']);
			$this->setError('IonAuth.update_unsuccessful');
			return false;
		}

		$this->db->transCommit();

		$this->triggerEvents(['post_update_user', 'post_update_user_successful']);
		$this->setMessage('IonAuth.update_successful');
		return true;
	}
	public function deleteUser(int $id): bool
	{
		if ($this->inGroup($this->config->adminGroup, $id)) {
			$this->setError('Admin Group Tidak Dapat Dihapus, Silahkan Ubah Kembali Ke Group User');
			return false;
		}

		$this->triggerEvents('pre_delete_user');
		$this->db->transBegin();
		// remove user from groups
		$this->removeFromGroup(null, $id);
		// delete user from users table should be placed after remove from group
		$this->db->table($this->tables['users'])->delete(['id' => $id]);
		if ($this->db->transStatus() === false) {
			$this->db->transRollback();
			$this->triggerEvents(['post_delete_user', 'post_delete_user_unsuccessful']);
			$this->setError('IonAuth.delete_unsuccessful');
			return false;
		}
		$this->db->transCommit();
		$this->triggerEvents(['post_delete_user', 'post_delete_user_successful']);
		$this->setMessage('delete_successful');
		return true;
	}
	//banned
	public function activate($id, string $code = ''): bool
	{
		$this->triggerEvents('pre_activate');

		if ($code) {
			$user = $this->getUserByActivationCode($code);
		}
		// Activate if no code is given
		// Or if a user was found with this code, and that it matches the id
		if (!$code || ($user && $user->id == $id)) {
			$data = [
				'activation_selector' => null,
				'activation_code'     => null,
				'active'              => 1,
			];

			$this->triggerEvents('extra_where');
			$this->db->table($this->tables['users'])->update($data, ['id' => $id]);

			if ($this->db->affectedRows() === 1) {
				$this->triggerEvents(['post_activate', 'post_activate_successful']);
				$this->setMessage('IonAuth.activate_successful');
				return true;
			}
		}
		$this->triggerEvents(['post_activate', 'post_activate_unsuccessful']);
		$this->setError('IonAuth.activate_unsuccessful');
		return false;
	}
	public function deactivate(int $id = 0): bool
	{
		$this->triggerEvents('deactivate');

		if (!$id) {
			$this->setError('IonAuth.deactivate_unsuccessful');
			return false;
		} else if ($this->recheckSession() && $this->user($this->session->get('user_id'))->id == $id) {
			$this->setError('IonAuth.deactivate_current_user_unsuccessful');
			return false;
		}
		$token                = $this->generateSelectorValidatorCouple(20, 40);
		$this->activationCode = $token->userCode;
		$data = [
			'activation_selector' => $token->selector,
			'activation_code'     => $token->validatorHashed,
			'active'              => 0,
		];
		$this->db->table($this->tables['users'])->update($data, ['id' => $id]);
		$return = $this->db->affectedRows() === 1;
		if ($return) {
			$this->setMessage('IonAuth.deactivate_successful');
			return true;
		} else {
			$this->setError('IonAuth.deactivate_unsuccessful');
			return false;
		}
	}
	public function clear_user(int $id = 0): bool
	{
		$this->triggerEvents('deactivate');

		if (!$id) {
			$this->setError('Gagal menghapus device');
			return false;
		} else if ($this->recheckSession() && $this->user($this->session->get('user_id'))->id == $id) {
			$this->setError('Gagal mengahpus device user ini');
			return false;
		}
		$token                = $this->generateSelectorValidatorCouple(20, 40);
		$this->activationCode = $token->userCode;
		$data = [
			'activation_selector' => $token->selector,
			'activation_code'     => $token->validatorHashed,
			'device_id'			  => null,
			'user_agent'		  => null,
			'player_id'			  => null,
		];
		$this->db->table($this->tables['users'])->update($data, ['id' => $id]);
		$return = $this->db->affectedRows() === 1;
		if ($return) {
			$this->setMessage('Berhasil membersihkan user device');
			return true;
		} else {
			$this->setError('Gagal membersihkan user');
			return false;
		}
	}
	//custom funnction
	protected function generateSelectorValidatorCouple(int $selectorSize = 40, int $validatorSize = 128): \stdClass
	{
		// The selector is a simple token to retrieve the user
		$selector = $this->randomToken($selectorSize);
		// The validator will strictly validate the user and should be more complex
		$validator = $this->randomToken($validatorSize);
		// The validator is hashed for storing in DB (avoid session stealing in case of DB leaked)
		$validatorHashed = $this->hashPassword($validator);
		// The code to be used user-side
		$userCode = $selector . '.' . $validator;

		return (object) [
			'selector'        => $selector,
			'validatorHashed' => $validatorHashed,
			'userCode'        => $userCode,
		];
	}
	protected function randomToken(int $resultLength = 32): string
	{
		if ($resultLength <= 8) {
			$resultLength = 32;
		}
		// Try random_bytes: PHP 7
		if (function_exists('random_bytes')) {
			return bin2hex(random_bytes($resultLength / 2));
		}
		// No luck!
		throw new \Exception('Unable to generate a random token');
	}
	protected function filterData(string $table, $data): array
	{
		$filteredData = [];
		$columns = $this->db->getFieldNames($table);

		if (is_array($data)) {
			foreach ($columns as $column) {
				if (array_key_exists($column, $data)) {
					$filteredData[$column] = $data[$column];
				}
			}
		}
		return $filteredData;
	}
	protected function retrieveSelectorValidatorCouple(string $userCode)
	{
		// Check code
		if ($userCode) {
			$tokens = explode('.', $userCode);
			// Check tokens
			if (count($tokens) === 2) {
				return (object) [
					'selector'  => $tokens[0],
					'validator' => $tokens[1],
				];
			}
		}
		return false;
	}
	public function createGroup(string $groupName = '', string $groupDescription = '', array $additionalData = [])
	{
		// bail if the group name was not passed
		if (!$groupName) {
			$this->setError('IonAuth.groupName_required');
			return false;
		}

		// bail if the group name already exists
		$existingGroup = $this->db->table($this->tables['groups'])->where(['name' => $groupName])->countAllResults();
		if ($existingGroup !== 0) {
			$this->setError('IonAuth.group_already_exists');
			return false;
		}

		$data = [
			'name'        => $groupName,
			'description' => $groupDescription,
		];

		// filter out any data passed that doesnt have a matching column in the groups table
		// and merge the set group data and the additional data
		if (!empty($additionalData)) {
			$data = array_merge($this->filterData($this->tables['groups'], $additionalData), $data);
		}

		$this->triggerEvents('extra_group_set');

		// insert the new group
		$this->db->table($this->tables['groups'])->insert($data);
		$groupId = $this->db->insertId($this->tables['groups'] . '_id_seq');

		// report success
		$this->setMessage('IonAuth.group_creation_successful');
		// return the brand new group id
		return $groupId;
	}

	/**
	 * Update group
	 *
	 * @param integer $groupId        Group id
	 * @param string  $groupName      Group name
	 * @param array   $additionalData Additional datas
	 *
	 * @return boolean
	 * @author aditya menon
	 */
	public function updateGroup(int $groupId, string $groupName = '', array $additionalData = []): bool
	{
		if (!$groupId) {
			return false;
		}

		$data = [];

		if (!empty($groupName)) {
			$existingGroup = $this->db->table($this->tables['groups'])->getWhere(['name' => $groupName])->getRow();
			if (isset($existingGroup->id) && (int)$existingGroup->id !== $groupId) {
				$this->setError('IonAuth.group_already_exists');
				return false;
			}
			$data['name'] = $groupName;
		}

		$group = $this->db->table($this->tables['groups'])->getWhere(['id' => $groupId])->getRow();
		if ($this->config->adminGroup === $group->name && $groupName !== $group->name) {
			$this->setError('IonAuth.groupName_admin_not_alter');
			return false;
		}
		if (!empty($additionalData)) {
			$data = array_merge($this->filterData($this->tables['groups'], $additionalData), $data);
		}

		$this->db->table($this->tables['groups'])->update($data, ['id' => $groupId]);

		$this->setMessage('IonAuth.group_update_successful');

		return true;
	}

	/**
	 * Remove a group.
	 *
	 * @param integer $groupId Group id
	 *
	 * @return boolean
	 * @author aditya menon
	 */
	public function deleteGroup(int $groupId): bool
	{
		// bail if mandatory param not set
		if (!$groupId || empty($groupId)) {
			return false;
		}
		$group = $this->group($groupId);
		if ($group->name === $this->config->adminGroup) {
			$this->triggerEvents(['post_delete_group', 'post_delete_group_notallowed']);
			$this->setError('IonAuth.group_delete_notallowed');
			return false;
		}

		$this->triggerEvents('pre_delete_group');

		$this->db->transBegin();

		// remove all users from this group
		$this->db->table($this->tables['users_groups'])->delete([$this->join['groups'] => $groupId]);
		// remove the group itself
		$this->db->table($this->tables['groups'])->delete(['id' => $groupId]);

		if ($this->db->transStatus() === false) {
			$this->db->transRollback();
			$this->triggerEvents(['post_delete_group', 'post_delete_group_unsuccessful']);
			$this->setError('IonAuth.group_delete_unsuccessful');
			return false;
		}

		$this->db->transCommit();

		$this->triggerEvents(['post_delete_group', 'post_delete_group_successful']);
		$this->setMessage('group_delete_successful');
		return true;
	}
	//pesan
	public function messages(): string
	{
		if (empty($this->messages)) {
			return '';
		}
		$messageLang = [];
		foreach ($this->messages as $message) {
			$messageLang[] = lang($message) !== $message ? lang($message) : '##' . $message . '##';
		}
		return view($this->messagesTemplates['list'], ['messages' => $messageLang]);
	}
	public function setMessage(string $message): string
	{
		$this->messages[] = $message;
		return $message;
	}
	public function clearMessages()
	{
		$this->messages = [];
		return true;
	}
	public function errors(string $template = 'list'): string
	{
		if (!array_key_exists($template, config('Validation')->templates)) {
			throw new \CodeIgniter\Exceptions\ConfigException(lang('Validation.invalidTemplate', [$template]));
		}
		if (empty($this->errors)) {
			return 'kossong bos';
		}
		$errors = [];
		foreach ($this->errors as $error) {
			$errors[] = lang($error) !== $error ? lang($error) : '##' . $error . '##';
		}
		return view(config('Validation')->templates[$template], ['errors' => $errors]);
	}
	public function setError(string $error): string
	{
		$this->errors[] = $error;
		return $error;
	}
	public function clearErrors(): bool
	{
		$this->errors = [];
		return true;
	}
	/**
	 * Set a single or multiple functions to be called when trigged by triggerEvents().
	 *
	 * @param string $event     Event
	 * @param string $name      Name
	 * @param string $class     Class
	 * @param string $method    Method
	 * @param array  $arguments Arguments
	 *
	 * @return self
	 */
	public function setHook(string $event, string $name, string $class, string $method, array $arguments = []): self
	{
		$this->ionHooks->{$event}[$name]            = new \stdClass;
		$this->ionHooks->{$event}[$name]->class     = $class;
		$this->ionHooks->{$event}[$name]->method    = $method;
		$this->ionHooks->{$event}[$name]->arguments = $arguments;
		return $this;
	}

	/**
	 * Remove hook
	 *
	 * @param string $event Event
	 * @param string $name  Name
	 *
	 * @return void
	 */
	public function removeHook(string $event, string $name): void
	{
		if (isset($this->ionHooks->{$event}[$name])) {
			unset($this->ionHooks->{$event}[$name]);
		}
	}

	/**
	 * Remove hooks
	 *
	 * @param string $event Event
	 *
	 * @return void
	 */
	public function removeHooks(string $event): void
	{
		if (isset($this->ionHooks->$event)) {
			unset($this->ionHooks->$event);
		}
	}

	/**
	 * Call hook
	 *
	 * @param string $event Event
	 * @param string $name  Name
	 *
	 * @return false|mixed
	 */
	protected function callHook(string $event, string $name)
	{
		if (isset($this->ionHooks->{$event}[$name]) && method_exists($this->ionHooks->{$event}[$name]->class, $this->ionHooks->{$event}[$name]->method)) {
			$hook = $this->ionHooks->{$event}[$name];
			return call_user_func_array([$hook->class, $hook->method], $hook->arguments);
		}
		return false;
	}

	/**
	 * Call Additional functions to run that were registered with setHook().
	 *
	 * @param string|array $events Event(s)
	 *
	 * @return void
	 */
	public function triggerEvents($events): void
	{
		if (is_array($events) && !empty($events)) {
			foreach ($events as $event) {
				$this->triggerEvents($event);
			}
		} else {
			if (isset($this->ionHooks->$events) && !empty($this->ionHooks->$events)) {
				foreach ($this->ionHooks->$events as $name => $hook) {
					$this->callHook($events, $name);
				}
			}
		}
	}
	//upload gambar
	public function upload_img($file, $file_name, $file_old, int $max_size = null, int $resize_h = null, int $resize_w = null): bool
	{
		$type = $file->getClientMimeType();
		$size = $file->getSize('mb');

		$max_size = isset($max_size) ? $max_size : '2'; // 2146304 in kb
		$resize_h = isset($resize_h) ? $resize_h : '250';
		$resize_w = isset($resize_w) ? $resize_w : '200';
		if ($type != (('image/png') or ('image/PNG') or ('image/jpeg') or ('image/jpg'))) {	// File Tipe Sesuai
			$this->setError('Extensi File Tidak Diizinkan.. Gunakan file .jpeg atau .png (Pastikan extensinya menggunakan huruf kecil)');
			return false;
		}
		if ($size <= $max_size) {
			$this->setError('Ukuran File Yang Anda Upload Melebihi Batas Maximum');
			return false;
		}
		helper('filesystem'); // Load Helper File System
		$direktori = ROOTPATH . 'public/assets/img/'; //definisikan direktori upload
		if (!empty($file_old)) {
			delete_files($direktori, $file_old); //Hapus terlebih dahulu jika file ada
		}
		$image = \Config\Services::image('gd'); //Load Image Libray
		$upload = $image->withFile($file)->resize($resize_h, $resize_w, false, 'height')
			->save($direktori . '' . $file_name);
		if ($upload) {
			$this->setMessage('file berhasil diuploads');
			return true;
		}
		$this->setError('File Gagal Di Upload');
		return false;
	}
}
