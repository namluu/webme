<?php
require_once (ROOT.DS.'config'.DS.'config.php');

function __autoload($class) {
    $libPath = ROOT.DS.'lib'.DS.strtolower($class).'.class.php';
    $controllerPath = ROOT.DS.'controllers'.DS.str_replace('controller', '', strtolower($class)).'.controller.php';
    $controllerAdmin = ROOT.DS.'controllers'.DS.'admin'.DS.str_replace('admin', '',
            str_replace('controller', '', strtolower($class))).'.admin.controller.php';
    $modelPath = ROOT.DS.'models'.DS.str_replace('model', '', strtolower($class)).'.model.php';

    if (file_exists($libPath)) {
        require_once ($libPath);
    } elseif (file_exists($controllerPath)) {
        require_once($controllerPath);
    } elseif (file_exists($controllerAdmin)) {
        require_once($controllerAdmin);
    } elseif (file_exists($modelPath)) {
        require_once($modelPath);
    }
}
// translate helpers
function __($key, $default = '') {
    if (!$default) {
        $default = $key;
    }
    return Lang::get($key, $default);
}

// link helpers
function getUrl($url = '') {
    return Config::get('base_url') . $url;
}
function getAdminUrl($url = '') {
    return Config::get('admin_url') . $url;
}
function getMenu($path, $name, $isAdmin = false) {
    $active = '';
    $pathParts = explode('/', $path);
    if (count($pathParts) >= 2) {
        // active action level
        $active = App::getRouter()->getAction() == $pathParts[1] ? ' class="active"':'';
    } elseif (count($pathParts) == 1) {
        // active controller level
        $active = App::getRouter()->getController() == $pathParts[0] ? ' class="active"':'';
    }

    echo '<li '.$active.'>';
    echo '<a href="'.($isAdmin ? getAdminUrl($path) : getUrl($path)).'"'. $active.'>'. $name.'</a>';
    echo '</li>';
}
function getAdminMenu($path, $name) {
    getMenu($path, $name, true);
}

function randomStr($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
function validateEmail($string)
{
    $domain = substr(strrchr($string, "@"), 1);
    if ( $domain != 'localhost' && !filter_var($string,FILTER_VALIDATE_EMAIL) ) {
        return false;
    }
    return true;
}