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
            } elseif (!preg_match("/^[a-zA-Z0-9]+$/",$fullname)) {
                $isError = true;
                $errorMsg[] = 'Name must contain alphabets and numbers.';
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

            // captcha validation

            if( !$isError ) {
                $hash = md5(Config::get('salt').$password);
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
            $email = $this->model->escape($_POST['username']);
            $password = $this->model->escape($_POST['password']);

            if ( !validateEmail($email) ) {
                Session::setMessage('error', 'Please enter valid email address.');
            } else {
                $user = $this->model->getBy('email', $email);
                $hash = md5(Config::get('salt') . $password);
                if ($user && $user['is_active'] && $hash === $user['password']) {
                    Session::set('username', $user['username']);
                    Session::set('role', 'user');
                    Router::redirect(getUrl('user/account'));
                } else {
                    Session::setMessage('error', 'Wrong account');
                }
            }
        }
        View::renderView();
    }

    public function logout()
    {
        Session::destroy();
        Router::redirect(getUrl());
    }

    public function forgotPassword()
    {
        if ($_POST && isset($_POST['email'])) {
            $email = $this->model->escape($_POST['email']);
            if ( !validateEmail($email) ) {
                Session::setMessage('error', 'Please enter valid email address.');
            } else {
                $user = $this->model->getBy('email', $email);
                if ($user && $user['is_active']) {
                    $token = randomStr(30);
                    $data = array(
                        'reset_token' => $token
                    );
                    $this->model->save($data, $user['id']);
                    Mailout::send($email, $token);
                    Session::setMessage('success', 'A reset password link sent to email "'.$email.'" successfully');
                } else {
                    Session::setMessage('error', 'Email "' . $email . '" not exist');
                }
            }
        }
        View::renderView();
    }

    public function resetPassword()
    {
        if (isset($this->params[0])) {
            $token = $this->params[0];
            $user = $this->model->getBy('reset_token', $token);
            if ($user && $user['is_active']) {
                if ($_POST && isset($_POST['password'])) {
                    $hash = md5(Config::get('salt') . $_POST['password']);
                    $data = array(
                        'password' => $hash,
                        'reset_token' => ''
                    );
                    $this->model->save($data, $user['id']);
                    Session::setMessage('success', 'Reset password successfully');
                    Router::redirect(getUrl('user/login'));
                }
                View::renderView();
            }
        }
        Session::setMessage('error', 'Token is invalid');
        Router::redirect(getUrl('user/forgotpassword'));
    }

    public function changePassword()
    {
        $username = Session::get('username');
        $user = $this->model->getBy('username', $username);
        if ($user && $user['is_active']) {
            if ($_POST && isset($_POST['password'])) {
                $hash = md5(Config::get('salt') . $_POST['password']);
                $data = array(
                    'password' => $hash
                );
                $this->model->save($data, $user['id']);
                Session::setMessage('success', 'Change password successfully');
                Router::redirect(getUrl('user/account'));
            }
            View::setPath('resetpassword');
            View::renderView();
        }
        Session::setMessage('error', 'Something was wrong');
        Router::redirect(getUrl());
    }

    public function account()
    {
        View::renderView();
    }
}