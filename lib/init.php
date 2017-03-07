<?php
require_once (ROOT.DS.'config'.DS.'config.php');

function __autoload($class) {
    $libPath = ROOT.DS.'lib'.DS.strtolower($class).'.class.php';
    $controllerPath = ROOT.DS.'controllers'.DS.str_replace('controller', '', strtolower($class)).'.controller.php';
    $modelPath = ROOT.DS.'models'.DS.str_replace('model', '', strtolower($class)).'.model.php';

    if (file_exists($libPath)) {
        require_once ($libPath);
    } elseif (file_exists($controllerPath)) {
        require_once ($controllerPath);
    } elseif (file_exists($modelPath)) {
        require_once($modelPath);
    } else {
        // throw on development env
        // redirect to 404 page on product env
        throw new Exception('Failed to include class: ' . $class);
    }
}

function __($key, $default = '') {
    if (!$default) {
        $default = $key;
    }
    return Lang::get($key, $default);
}

function getUrl($url = '') {
    return Config::get('base_url') . $url;
}

function getAdminUrl($url = '') {
    return Config::get('admin_url') . $url;
}

function getMenu($path, $controller, $name) {
    $active = App::getRouter()->getController() == $controller ? ' class="active"':'';
    echo '<li '.$active.'>';
    echo '<a href="'.getUrl($path).'"'. $active.'>'. $name.'</a>';
    echo '</li>';
}

function getAdminMenu($path, $controller, $name) {
    $active = App::getRouter()->getController() == $controller ? ' class="active"':'';
    echo '<li '.$active.'>';
    echo '<a href="'.getAdminUrl($path).'"'. $active.'>'. $name.'</a>';
    echo '</li>';
}