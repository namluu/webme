<?php

class UserAdminController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new UserAdminModel();
    }

    public function login()
    {
        if ($_POST && isset($_POST['username']) && isset($_POST['password'])) {
            $username = $this->model->escape($_POST['username']);
            $password = $this->model->escape($_POST['password']);

            $user = $this->model->getBy('username', $username);
            $hash = md5(Config::get('salt').$password);
            if ($user && $user['is_active'] && $hash === $user['password']) {
                Session::set('username', $user['username']);
                Session::set('role', $user['role']);
                Router::redirect(getAdminUrl());
            } else {
                Session::setMessage('error', 'Wrong account');
            }
        }
        View::renderView('', 'login');
    }

    public function logout()
    {
        Session::destroy();
        Router::redirect(getAdminUrl());
    }
}