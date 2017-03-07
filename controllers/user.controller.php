<?php

class UserController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new UserModel();
    }

    public function admin_login()
    {
        if ($_POST && isset($_POST['username']) && isset($_POST['password'])) {
            $user = $this->model->getBy('username', $_POST['username']);
            $hash = md5(Config::get('salt').$_POST['password']);
            if ($user && $user['is_active'] && $hash === $user['password']) {
                Session::set('username', $user['username']);
                Session::set('role', $user['role']);
            }
            Router::redirect(getAdminUrl());
        }
        View::renderView('', 'login');
    }

    public function admin_logout()
    {
        Session::destroy();
        Router::redirect(getAdminUrl());
    }
}