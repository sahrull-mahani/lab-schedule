<?php

namespace App\Controllers;

use App\Models\PegawaiM;

class Auth extends BaseController
{
    public $data = [];
    protected $configIonAuth, $session, $ionAuth;
    protected $validation, $validationListTemplate;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->configIonAuth = config('IonAuth');
    }
    public function index()
    {
        if (!is_admin()) {
            $this->session->setFlashdata(
                'message',
                'You must be an administrator to view this page.'
            );
            return redirect()->to('login');
        }
        $this->data = [
            'title'     => lang('Auth.index_heading'),
            'breadcome' => lang('Auth.index_subheading'),
            'session'   => $this->session,
            'url'       => 'auth/',
            'm_users'   => 'active bg-gradient-primary',
        ];
        return view('App\Views\auth\index', $this->data);
    }
    public function login()
    {
        $this->data['title'] = lang('Auth.login_heading');
        // validate form input
        $this->validation->setRule(
            'identity',
            str_replace(':', '', lang('Auth.login_identity_label')),
            'required'
        );
        $this->validation->setRule(
            'password',
            str_replace(':', '', lang('Auth.login_password_label')),
            'required'
        );

        if (
            $this->request->getPost() &&
            $this->validation->withRequest($this->request)->run()
        ) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->request->getVar('remember');
            if (
                $this->ionAuth->login(
                    $this->request->getVar('identity'),
                    $this->request->getVar('password'),
                    $remember
                )
            ) {
                $status['type'] = 'success';
                $status['text'] = $this->ionAuth->messages();
                $status['title'] = 'Success';
            } else {
                $status['type'] = 'error';
                $status['text'] = $this->ionAuth->errors(
                    $this->validationListTemplate
                );
                $status['title'] = 'Error';
            }
            echo json_encode($status);
        } else {
            $this->data['message'] = $this->validation->listErrors(
                $this->validationListTemplate
            );
            return view('App\Views\auth\login', $this->data);
        }
    }
    public function logout()
    {
        // log the user out
        $this->ionAuth->logout();
        // redirect them to the login page
        $this->session->setFlashdata('message', $this->ionAuth->messages());
        return redirect()
            ->to('login')
            ->withCookies();
    }
    public function create_user()
    {
        if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
            return redirect()->to('/auth');
        }
        $this->data['action'] = 'insert';
        $this->data['btn'] = lang('Auth.create_user_submit_btn');
        $this->data['required'] = 'required="required"';
        $this->data['identity_column'] = $this->configIonAuth->identity;

        $status['html']         = view('App\Views\auth\form_user', $this->data);
        $status['modal_title']  = lang('Auth.create_user_heading');
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit_user()
    {
        $this->data['title'] = lang('Auth.edit_user_heading');
        $this->data['sub_title'] = lang('Auth.edit_user_subheading');
        $id = $this->request->getPost('id');
        if (!$this->ionAuth->isAdmin() && !($this->ionAuth->user()->id == $id)) {
            return redirect()->to('/login');
        }
        $id = (int)implode('', $id);
        $user = $this->ionAuth->user($id);
        $groups = $this->ionAuth->groups();
        $currentGroups = $this->ionAuth->getUsersGroups($id)->getResult();

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['ionAuth'] = $this->ionAuth;
        $this->data['action'] = 'update';
        $this->data['btn'] = 'Update';
        $this->data['required'] = '';
        $this->data['identity_column'] = $this->configIonAuth->identity;

        $status['html']         = view('App\Views\auth\form_user', $this->data);
        $status['modal_title']  = lang('Auth.edit_user_heading');
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function save()
    {
        $nama = $this->request->getVar('nama_user');
        if (!$nama) {
            $this->validation->setRule(
                'id_peg',
                lang('Auth.create_user_validation_name_label'),
                'required'
            );
        }
        $this->validation->setRule(
            'phone',
            lang('Auth.edit_user_validation_phone_label'),
            'trim|required'
        );
        switch ($this->request->getPost('action')) {
            case 'insert':
                $tables = $this->configIonAuth->tables;
                $identityColumn = $this->configIonAuth->identity;
                if ($identityColumn !== 'email') {
                    $this->validation->setRule(
                        'identity',
                        lang('Auth.create_user_validation_identity_label'),
                        'trim|required|is_unique[' . $tables['users'] . '.' . $identityColumn . ']'
                    );
                    $this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email');
                } else {
                    $this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
                    // $this->validation->setRule('email',lang('Auth.create_user_validation_email_label'),'trim|required|is_unique[' .$tables['users'] .'.email]');
                }
                $this->validation->setRule(
                    'password',
                    lang('Auth.create_user_validation_password_label'),
                    'required|min_length[' .
                        $this->configIonAuth->minPasswordLength .
                        ']|matches[password_confirm]'
                );
                $this->validation->setRule(
                    'password_confirm',
                    lang('Auth.create_user_validation_password_confirm_label'),
                    'required'
                );

                if ($this->validation->withRequest($this->request)->run()) {
                    $email = strtolower($this->request->getPost('email'));
                    $identity = $identityColumn === 'email' ? $email : $this->request->getPost('identity');
                    $password = $this->request->getPost('password');
                    $id_peg = $this->request->getPost('id_peg');
                    if (!$nama) {
                        $additionalData = [
                            'id_peg' => ($id_peg != 'none') ? $id_peg : null,
                            'nama_user' => ($id_peg != 'none') ? pegawaiById($id_peg)->nama : $identity,
                            'phone' => $this->request->getPost('phone'),
                        ];
                        $groups = [3];
                    } else {
                        $additionalData = [
                            'id_peg'    => null,
                            'nama_user' => $nama,
                            'phone'     => $this->request->getPost('phone'),
                        ];
                        $groups = [$this->request->getPost('group')];
                        $emailNonActived = true;
                    }
                    if (
                        $this->ionAuth->register(
                            $identity,
                            $password,
                            $email,
                            $additionalData,
                            $groups,
                            $emailNonActived ?? null,
                        )
                    ) {
                        // check to see if we are creating the user
                        // redirect them back to the admin page
                        $status['type'] = 'success';
                        $status['text'] = $this->ionAuth->messages();
                        $status['title'] = 'Success';
                    } else {
                        $status['type'] = 'error';
                        $status['text'] = $this->ionAuth->errors(
                            $this->validationListTemplate
                        );
                        $status['title'] = 'Error';
                    }
                } else {
                    // dd('disinin jo');
                    $status['type'] = 'warning';
                    $status['text'] = $this->validation->listErrors(
                        $this->validationListTemplate
                    );
                    $status['title'] = 'Error';
                }
                echo json_encode($status);
                break;
            case 'update':
                $tables = $this->configIonAuth->tables;
                $identityColumn = $this->configIonAuth->identity;
                $id = $this->request->getPost('id');
                if ($this->request->getPost('password')) {
                    $this->validation->setRule(
                        'password',
                        lang('Auth.edit_user_validation_password_label'),
                        'required|min_length[' .
                            $this->configIonAuth->minPasswordLength .
                            ']|matches[password_confirm]'
                    );
                    $this->validation->setRule(
                        'password_confirm',
                        lang(
                            'Auth.edit_user_validation_password_confirm_label'
                        ),
                        'required'
                    );
                }
                $email      = strtolower($this->request->getPost('email'));
                $user       = $this->ionAuth->user($id);
                if ($email != $user->email) {
                    $this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|is_unique[' . $tables['users'] . '.email]');
                }
                if ($this->validation->withRequest($this->request)->run()) {
                    $id_peg = $this->request->getPost('id_peg');
                    $identity = $identityColumn === 'email' ? $email : $this->request->getPost('identity');
                    $data = [
                        'id_peg' => ($id_peg != 'none') ? $id_peg : null,
                        'nama_user' => ($id_peg != 'none') ? pegawaiById($id_peg)->nama : $identity,
                        'phone' => $this->request->getPost('phone'),
                        'email' => $email,
                    ];
                    if ($identityColumn === 'username') {
                        $data['username'] = $identity;
                    }
                    // update the password if it was posted
                    if ($this->request->getPost('password')) {
                        $data['password'] = $this->request->getPost('password');
                    }
                    // Only allow updating groups if user is admin
                    if ($this->ionAuth->isAdmin()) {
                        // Update the groups user belongs to
                        $groupData = $this->request->getPost('groups');
                        if (!empty($groupData)) {
                            $this->ionAuth->removeFromGroup('', $id);
                            foreach ($groupData as $grp) {
                                $this->ionAuth->addToGroup($grp, $id);
                            }
                        }
                    }
                    // check to see if we are updating the user
                    if ($this->ionAuth->update($id, $data)) {
                        $status['type'] = 'success';
                        $status['text'] = $this->ionAuth->messages();
                        $status['title'] = 'Success';
                    } else {
                        $status['type'] = 'error';
                        $status['text'] = $this->ionAuth->errors(
                            $this->validationListTemplate
                        );
                        $status['title'] = 'Error';
                    }
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->validation->listErrors(
                        $this->validationListTemplate
                    );
                    $status['title'] = 'Error';
                }
                echo json_encode($status);
                break;
            case 'delete':
                $id = $this->request->getPost('id');
                $success = [];
                $failed = [];
                foreach ($id as $ids) {
                    if ($this->ionAuth->deleteUser($ids)) {
                        $success[] = 'success';
                    } else {
                        $failed[] = 'failed';
                    }
                }
                $jum_success = count($success);
                $jum_failed = count($failed);
                if (count($success) > 0) {
                    $status['type'] = 'success';
                    $status['text'] =
                        '<strong>Deleted..!</strong>Berhasil dihapus ' .
                        $jum_success .
                        ', Gagal dihapus ' .
                        $jum_failed .
                        '..!!!';
                    $status['title'] = 'Success';
                } else {
                    $status['type'] = 'error';
                    $status['text'] =
                        '<strong>Oh snap!</strong> ' .
                        $this->ionAuth->errors($this->validationListTemplate) .
                        ' ' .
                        $failed[0];
                    $status['title'] = 'Error';
                }
                echo json_encode($status);
                break;
        }
    }
    //group
    public function groups()
    {
        if (!$this->ionAuth->isAdmin()) {
            return redirect()->to('/auth');
        }
        $this->data['groups'] = $this->ionAuth->groups();

        $status['html']         = view('auth\groups', $this->data);
        $status['modal_title']  = lang('Auth.edit_user_heading');
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function create_group()
    {
        if (!$this->ionAuth->isAdmin()) {
            return redirect()->to('/auth');
        }
        $this->data['action'] = 'insert';
        $this->data['btn'] = lang('Auth.create_group_submit_btn');

        $status['html']         = view('App\Views\auth\form_group', $this->data);
        $status['modal_title']  = lang('Auth.create_group_heading');
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit_group(int $id)
    {
        if (!$this->ionAuth->isAdmin()) {
            return redirect()->to('/auth');
        }
        $group = $this->ionAuth->group($id);
        $this->data['group'] = $group;

        $readonly = $this->configIonAuth->adminGroup === $group->name ? 'readonly' : '';

        $this->data['id'] = $id;
        $this->data['group_name'] = $group->name;
        $this->data['group_description'] = $group->description;
        $this->data['readonly'] = $readonly;
        $this->data['action'] = 'update';
        $this->data['btn'] = lang('Auth.edit_group_submit_btn');

        $status['html']         = view('App\Views\auth\form_group', $this->data);
        $status['modal_title']  = lang('Auth.edit_group_title') . " $group->name";
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function save_groups()
    {
        if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
            return redirect()->to('/auth');
        }
        switch ($this->request->getPost('action')) {
            case 'insert':
                $this->validation->setRule(
                    'group_name',
                    lang('Auth.create_group_validation_name_label'),
                    'trim|required|alpha_dash'
                );
                if (
                    $this->request->getPost() &&
                    $this->validation->withRequest($this->request)->run()
                ) {
                    $newGroupId = $this->ionAuth->createGroup(
                        $this->request->getPost('group_name'),
                        $this->request->getPost('description')
                    );
                    if ($newGroupId) {
                        $status['type'] = 'success';
                        $status['text'] = $this->ionAuth->messages();
                        $status['title'] = 'Success';
                    } else {
                        $status['type'] = 'error';
                        $status['text'] = $this->ionAuth->errors(
                            $this->validationListTemplate
                        );
                        $status['title'] = 'Error';
                    }
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->validation->listErrors(
                        $this->validationListTemplate
                    );
                    $status['title'] = 'Error';
                }
                echo json_encode($status);
                break;
            case 'update':
                $this->validation->setRule(
                    'group_name',
                    lang('Auth.edit_group_validation_name_label'),
                    'required|alpha_dash'
                );
                if ($this->validation->withRequest($this->request)->run()) {
                    $groupUpdate = $this->ionAuth->updateGroup(
                        $this->request->getPost('id'),
                        $this->request->getPost('group_name'),
                        [
                            'description' => $this->request->getPost(
                                'description'
                            ),
                        ]
                    );
                    if ($groupUpdate) {
                        $this->session->setFlashdata(
                            'message',
                            lang('Auth.edit_group_saved')
                        );
                        $status['type'] = 'success';
                        $status['text'] = lang('Auth.edit_group_saved');
                        $status['title'] = 'Success';
                    } else {
                        $status['type'] = 'error';
                        $status['text'] = $this->ionAuth->errors(
                            $this->validationListTemplate
                        );
                        $status['title'] = 'Error';
                    }
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->validation->listErrors(
                        $this->validationListTemplate
                    );
                    $status['title'] = 'Error';
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->ionAuth->deleteGroup($this->request->getPost('id'))) {
                    $status['type'] = 'success';
                    $status['text'] = 'Success Delete Groups';
                    $status['title'] = 'Success';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->ionAuth->errors(
                        $this->validationListTemplate
                    );
                    $status['title'] = 'Error';
                }
                echo json_encode($status);
                break;
        }
    }
    public function emailActivation(int $id, string $code = '')
    {
        $activation = $this->ionAuth->activate($id, $code);
        if ($activation) {
            return redirect()->to('login');
        } else {
            return 'GAGAL';
        }
    }
    public function activate(int $id, string $code = '')
    {
        $activation = false;

        if ($code) {
            $activation = $this->ionAuth->activate($id, $code);
        } elseif ($this->ionAuth->isAdmin()) {
            $activation = $this->ionAuth->activate($id);
        }

        if ($activation) {
            $status['type'] = 'success';
            $status['text'] = $this->ionAuth->messages();
            $status['title'] = 'Success';
        } else {
            $status['type'] = 'error';
            $status['text'] = $this->ionAuth->errors(
                $this->validationListTemplate
            );
            $status['title'] = 'Error';
        }
        echo json_encode($status);
    }
    public function deactivate(int $id = 0)
    {
        if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
            // redirect them to the home page because they must be an administrator to view this
            throw new \Exception(
                'You must be an administrator to view this page.'
            );
            // TODO : I think it could be nice to have a dedicated exception like '\IonAuth\Exception\NotAllowed
        }
        if ($this->ionAuth->deactivate($id)) {
            $status['type'] = 'success';
            $status['text'] = $this->ionAuth->messages();
            $status['title'] = 'Success';
        } else {
            $status['type'] = 'error';
            $status['text'] = $this->ionAuth->errors(
                $this->validationListTemplate
            );
            $status['title'] = 'Error';
        }
        echo json_encode($status);
    }
    public function clear_user(int $id = 0)
    {
        if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
            // redirect them to the home page because they must be an administrator to view this
            throw new \Exception(
                'You must be an administrator to view this page.'
            );
            // TODO : I think it could be nice to have a dedicated exception like '\IonAuth\Exception\NotAllowed
        }
        if ($this->ionAuth->clear_user($id)) {
            $status['type'] = 'success';
            $status['text'] = $this->ionAuth->messages();
            $status['title'] = 'Success';
        } else {
            $status['type'] = 'error';
            $status['text'] = $this->ionAuth->errors(
                $this->validationListTemplate
            );
            $status['title'] = 'Error';
        }
        echo json_encode($status);
    }
    public function ajax_request()
    {
        if (!$this->ionAuth->loggedIn()) {
            return redirect()->to('/auth/login');
        }
        $list = $this->ionAuth->get_datatables();
        $data = [];
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $group = [];
            foreach ($this->ionAuth->getUsersGroups($rows->id)->getResult() as $value) {
                $group[] = $value->name;
            }
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['nama_user'] = $rows->nama_user;
            $row['username'] = $rows->username;
            $row['email'] = $rows->email;
            $row['group'] = $group;
            $row['active'] = $rows->active
                ? '<a class="btn btn-success btn-sm" href="javascript:void(0)" onclick="activate(' .
                "'" .
                site_url('auth/deactivate/' . $rows->id) .
                "'" .
                ',1)"> ' .
                lang('Auth.index_active_link') .
                '</a>'
                : '<a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="activate(' .
                "'" .
                site_url('auth/activate/' . $rows->id) .
                "'" .
                ')"> ' .
                lang('Auth.index_inactive_link') .
                '</a>';
            $data[] = $row;
        }
        $output = [
            "total" => $this->ionAuth->count_filtered(),
            "totalNotFiltered" => $this->ionAuth->count_all(),
            "rows" => $data,
        ];
        //output to json format
        echo json_encode($output);
    }
    //lupa pass
    public function forgot_password()
    {
        $this->data['title'] = lang('Auth.forgot_password_heading');

        // setting validation rules by checking whether identity is username or email
        if ($this->configIonAuth->identity !== 'email') {
            $this->validation->setRule(
                'identity',
                lang('Auth.forgot_password_identity_label'),
                'required'
            );
        } else {
            $this->validation->setRule(
                'identity',
                lang('Auth.forgot_password_validation_email_label'),
                'required|valid_email'
            );
        }

        if (
            !($this->request->getPost() &&
                $this->validation->withRequest($this->request)->run()
            )
        ) {
            $this->data['type'] = $this->configIonAuth->identity;

            if ($this->configIonAuth->identity !== 'email') {
                $this->data['identity_label'] = lang(
                    'Auth.forgot_password_identity_label'
                );
            } else {
                $this->data['identity_label'] = lang(
                    'Auth.forgot_password_email_identity_label'
                );
            }

            // set any errors and display the form
            $this->data['message'] = $this->validation->getErrors()
                ? $this->validation->listErrors($this->validationListTemplate)
                : $this->session->getFlashdata('message');
            return view('App\Views\auth\forgot_password', $this->data);
        } else {
            $identity = $this->ionAuth
                ->getUserFromIdentity($this->request->getPost('identity'))
                ->limit(1)
                ->get()
                ->getRow();
            if (empty($identity)) {
                if ($this->configIonAuth->identity !== 'email') {
                    $this->ionAuth->setError(
                        'Auth.forgot_password_identity_not_found'
                    );
                } else {
                    $this->ionAuth->setError(
                        'Auth.forgot_password_email_not_found'
                    );
                }
                $status['type'] = 'error';
                $status['text'] = $this->ionAuth->errors(
                    $this->validationListTemplate
                );
                $status['title'] = 'Error';
                echo json_encode($status);
                return false;
            }
            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ionAuth->forgottenPassword(
                $identity->{$this->configIonAuth->identity}
            );
            if ($forgotten) {
                $status['type'] = 'success';
                $status['text'] = $this->ionAuth->messages();
                $status['title'] = 'Success';
            } else {
                $status['type'] = 'error';
                $status['text'] = $this->ionAuth->errors(
                    $this->validationListTemplate
                );
                $status['title'] = 'Error';
            }
            echo json_encode($status);
        }
    }
    public function reset_password($code = null)
    {
        if (!$code) {
            $this->session->setFlashdata('message', 'code is empty');
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->data['title'] = lang('Auth.reset_password_heading');

        $user = $this->ionAuth->forgottenPasswordCheck($code);

        if ($user) {
            // if the code is valid then display the password reset form

            $this->validation->setRule(
                'new',
                lang('Auth.reset_password_validation_new_password_label'),
                'required|min_length[' .
                    $this->configIonAuth->minPasswordLength .
                    ']|matches[new_confirm]'
            );
            $this->validation->setRule(
                'new_confirm',
                lang(
                    'Auth.reset_password_validation_new_password_confirm_label'
                ),
                'required'
            );

            if (!$this->request->getPost()) {
                $this->data['minPasswordLength'] =
                    $this->configIonAuth->minPasswordLength;
                $this->data['code'] = $code;
                $this->data['user_id'] = $user->id;
                $this->data['message'] = $this->session->getFlashdata(
                    'message'
                );
                // render
                return view('auth\reset_password', $this->data);
            } else {
                $identity = $user->{$this->configIonAuth->identity};


                // do we have a valid request?
                if ($user->id != $this->request->getPost('user_id')) {
                    // something fishy might be up
                    $this->ionAuth->clearForgottenPasswordCode($identity);
                    throw new \Exception(lang('Auth.error_security'));
                } elseif (
                    $this->validation->withRequest($this->request)->run()
                ) {
                    // finally change the password
                    $change = $this->ionAuth->resetPassword(
                        $identity,
                        $this->request->getPost('new')
                    );
                    if ($change) {
                        $status['type'] = 'success';
                        $status['text'] = $this->ionAuth->messages();
                        $status['title'] = 'Success';
                    } else {
                        $status['type'] = 'error';
                        $status['text'] = $this->ionAuth->errors(
                            $this->validationListTemplate
                        );
                        $status['title'] = 'Error';
                    }
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->validation->listErrors(
                        $this->validationListTemplate
                    );
                    $status['title'] = 'Error';
                }
                echo json_encode($status);
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->setFlashdata(
                'message',
                $this->ionAuth->errors($this->validationListTemplate)
            );
            return redirect()->to('forgot-password');
        }
    }
    public function change_password()
    {
        if ($this->request->getPost('new')) {
            $this->validation->setRule(
                'old',
                lang('Auth.change_password_validation_old_password_label'),
                'required'
            );
            $this->validation->setRule(
                'new',
                lang('Auth.change_password_validation_new_password_label'),
                'required|min_length[' .
                    $this->configIonAuth->minPasswordLength .
                    ']|matches[new_confirm]'
            );
            $this->validation->setRule(
                'new_confirm',
                lang('Auth.change_password_validation_new_password_confirm_label'),
                'required'
            );
        }
        $this->validation->setRule(
            'phone',
            lang('Auth.edit_user_validation_phone_label'),
            'trim|required'
        );
        if (!$this->request->getPost() || $this->validation->withRequest($this->request)->run() === false) {
            $status['type'] = 'error';
            $status['text'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message') . "asdfasfd";
            $status['title'] = 'Error';
        } else {
            $identityColumn = $this->configIonAuth->identity;
            $id = $this->request->getPost('id');
            $email = strtolower($this->request->getPost('email'));
            $username = strtolower($this->request->getPost('username'));
            $identity = $identityColumn === 'email' ? $email : $username;
            $data = [
                'nama_user' => $this->request->getPost('nama_user'),
                'phone' => $this->request->getPost('phone'),
                'email' => strtolower($email),
                'username' => strtolower($username),
            ];
            // check to see if we are updating the user
            if ($this->ionAuth->update($id, $data)) {
                if ($this->request->getPost('new')) {
                    if ($this->ionAuth->changePassword(
                        $identity,
                        $this->request->getPost('old'),
                        $this->request->getPost('new')
                    )) {
                        $status['type'] = 'success';
                        $status['text'] = $this->ionAuth->messages();
                        $status['title'] = 'Success';
                        $this->logout();
                    } else {
                        $status['type'] = 'error';
                        $status['text'] = $this->ionAuth->errors($this->validationListTemplate);
                        $status['title'] = 'Error';
                    }
                } else {
                    $status['type'] = 'success';
                    $status['text'] = $this->ionAuth->messages();
                    $status['title'] = 'Success';
                    session()->remove('nama_user');
                    session()->set('nama_user', $this->request->getPost('nama_user'));
                }
            } else {
                $status['type'] = 'error';
                $status['text'] = $this->ionAuth->errors($this->validationListTemplate);
                $status['title'] = 'Error';
            }
        }
        echo json_encode($status);
    }
    public function profile()
    {
        $this->data['title'] = 'Profile';
        $this->data['message'] = $this->validation->getErrors()
            ? $this->validation->listErrors($this->validationListTemplate)
            : $this->session->getFlashdata('message');
        $this->data['session'] = $this->session;
        $this->data['m_Bprofile'] = 'active bg-gradient-primary';
        $this->data['m_profile'] = 'active bg-gradient-primary';
        $this->data['breadcome'] = 'Profile User';
        $this->data['identityColumn'] =  $this->configIonAuth->identity;
        $pegawai = new PegawaiM();
        $user = $this->ionAuth->user($this->session->user_id);
        $this->data['user'] = $user;
        $this->data['get'] = isset($user->id_peg) ? $pegawai->find($user->id_peg) : $user;

        $this->data['minPasswordLength'] =
            $this->configIonAuth->minPasswordLength;
        $this->data['old_password'] = [
            'name' => 'old',
            'id' => 'old',
            'type' => 'password',
            'class' => 'form-control',
            'placeholder' => lang('Auth.change_password_old_password_label'),
        ];
        $this->data['new_password'] = [
            'name' => 'new',
            'id' => 'new',
            'type' => 'password',
            'class' => 'form-control',
            'data-validate-length-range' => '8,20',
            'placeholder' => sprintf(
                lang('Auth.change_password_new_password_label'),
                $this->data['minPasswordLength']
            ),
        ];
        $this->data['new_password_confirm'] = [
            'name' => 'new_confirm',
            'id' => 'new_confirm',
            'type' => 'password',
            'class' => 'form-control',
            'data-validate-linked' => 'new',
            'placeholder' => lang(
                'Auth.change_password_new_password_confirm_label'
            ),
        ];
        return view('App\Views\auth\profile', $this->data);
    }
    public function save_profile()
    {
        if (!empty($_FILES['file-img']['name'])) {
            $file = $this->request->getFile('file-img');
            $file_name = $file->getRandomName();
            $file_old = $this->request->getPost('old_foto');
            if ($this->ionAuth->upload_img($file, $file_name, $file_old)) {
                $data = ['img' => $file_name];
                $this->ionAuth->update(
                    $this->request->getPost('user_id'),
                    $data
                );
                $this->session->remove('foto');
                $this->session->set(
                    'foto',
                    base_url('/assets/img/' . $file_name)
                );
            } else {
                $status['type'] = 'error';
                $status['text'] = $this->ionAuth->errors(
                    $this->validationListTemplate
                );
                $status['title'] = 'Error';
                echo json_encode($status);
                return false;
            }
        }
        $data = [
            'full_name' => $this->request->getPost('nama_user'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];
        if ($this->ionAuth->update($this->request->getPost('user_id'), $data)) {
            $status['type'] = 'success';
            $status['text'] = $this->ionAuth->messages();
            $status['title'] = 'Success';
        } else {
            $status['type'] = 'error';
            $status['text'] = $this->ionAuth->errors(
                $this->validationListTemplate
            );
            $status['title'] = 'Error';
        }
        echo json_encode($status);
    }
    public function change_pic()
    {
        $file = $this->request->getFile('profile');
        $file_name = 'profile_pic-' . $file->getRandomName();
        $file_old = $this->ionAuth->user(session('user_id'))->img;
        if ($this->upload_img($file_name, $file)) {
            $data = ['img' => $file_name];
            $this->ionAuth->update(
                session('user_id'),
                $data
            );

            if (file_exists(WRITEPATH . "uploads/img/$file_old") && file_exists(WRITEPATH . "uploads/thumbs/$file_old") && !empty($file_old)) {
                unlink(WRITEPATH . "uploads/img/$file_old");
                unlink(WRITEPATH . "uploads/thumbs/$file_old");
            }

            session()->remove('full');
            session()->set('full', site_url("full/$file_name"));
            session()->remove('thumb');
            session()->set('thumb', site_url("thumb/$file_name"));

            $status['type'] = 'success';
            $status['text'] = "Berhasil diganti";
            $status['title'] = 'Success';
            $status['image'] = session('full');
        } else {
            $status['type'] = 'error';
            $status['text'] = session()->getFlashdata('error');
            $status['title'] = 'Error';
        }
        return json_encode($status);
    }
    private function upload_img($file_name, $img): bool
    {
        $validationRule = [
            'profile' => [
                'label' => 'IMG File',
                'rules' => 'uploaded[profile]'
                    . '|is_image[profile]'
                    . '|mime_in[profile,image/jpg,image/jpeg,image/png]'
                    . '|max_size[profile,2048]',
                // . '|max_dims[galeri,1920,1080]',
                'errors' => [
                    'uploaded'  => 'Pastikan sudah memasukan gambar',
                    'is_image'  => 'Pastikan yang di upload adalah gambar',
                    'mime_in'   => 'Extensi yang boleh [jpg,jpeg,png]',
                    'max_size'  => 'Ukuran gambar terlalu besar MAX 2MB'
                ]
            ],
        ];
        if (!$this->validate($validationRule)) {
            $this->session->setFlashdata('error', $this->validator->getError('profile'));
            return false;
        }
        $filepath = WRITEPATH . 'uploads/';

        if (!$img->hasMoved()) {

            $image = \Config\Services::image('gd'); //Load Image Libray
            $image->withFile($img)->save($filepath . 'img/' . $file_name);
            //thumbs
            $image->withFile($img)
                ->fit(500, 500, 'center')
                ->save($filepath . 'thumbs/' . $file_name);
            // $img->move($filepath, $file_name, true);
            return true;
        } else {
            $this->session->setFlashdata('error', $img->getErrorString() . '(' . $img->getError() . ')');
            return false;
        }
    }
    public function redirectUser()
    {
        if ($this->ionAuth->isAdmin()) {
            return redirect()->to('auth');
        }
        return redirect()->to('admin');
    }
}
