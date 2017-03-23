<?php

class UserController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new UserModel();
    }

    public function register()
    {
        $isError = false;
        $errorMsg = array();
        $dataCache = array();

        if( isset($_POST['btn-register']) ) {
            // clean user inputs to prevent sql injections
            $fullname = $this->cleanInput($_POST['fullname']);
            $email = $this->cleanInput($_POST['email']);
            $password = $this->cleanInput($_POST['password']);

            // basic name validation
            if (empty($fullname)) {
                $isError = true;
                $errorMsg[] = 'Please enter your full name.';
            } elseif (strlen($fullname) < 3) {
                $isError = true;
                $errorMsg[] = 'Name must have at least 3 characters.';
            } elseif (!preg_match("/^[a-zA-Z0-9 ]+$/",$fullname)) {
                $isError = true;
                $errorMsg[] = 'Name must contain alphabets and space.';
            } else {
                // check fullname exist or not
                $count = $this->model->countBy('username', $fullname);
                if ($count) {
                    $isError = true;
                    $errorMsg[] = 'Provided FullName is already in use.';
                }
                $dataCache['fullname'] = $fullname;
            }
            // basic email validation
            if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
                $isError = true;
                $errorMsg[] = 'Please enter valid email address.';
            } else {
                // check email exist or not
                $count = $this->model->countBy('email', $email);
                if ($count) {
                    $isError = true;
                    $errorMsg[] = 'Provided Email is already in use.';
                }
                $dataCache['email'] = $email;
            }
            // password validation
            if (empty($password)){
                $isError = true;
                $errorMsg[] = "Please enter password.";
            } else if(strlen($password) < 6) {
                $isError = true;
                $errorMsg[] = 'Password must have at least 6 characters.';
            }
            $hash = md5(Config::get('salt').$password);

            if( !$isError ) {
                $data = array(
                    'username' => $fullname,
                    'password' => $hash,
                    'email' => $email
                );
                $this->model->save($data);
                Session::setMessage('success', 'Register successfully');
                Router::redirect(getUrl('user/login'));
            } else {
                Session::setMessage('error', join('<br>', $errorMsg));
            }
        }
        View::renderView($dataCache);
    }

    public function login()
    {
        if ($_POST && isset($_POST['username']) && isset($_POST['password'])) {
            $username = $this->model->escape($_POST['username']);
            $password = $this->model->escape($_POST['password']);

            $user = $this->model->getBy('email', $username);
            $hash = md5(Config::get('salt').$password);
            if ($user && $user['is_active'] && $hash === $user['password']) {
                Session::set('username', $user['username']);
                Session::set('role', 'user');
                Router::redirect(getUrl('user/account'));
            } else {
                Session::setMessage('error', 'Wrong account');
            }
        }
        View::renderView();
    }

    public function logout()
    {
        Session::destroy();
        Router::redirect(getUrl());
    }

    public function account()
    {
        View::renderView();
    }
}