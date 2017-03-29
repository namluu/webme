<?php
class View
{
    static $path;

    static $layout;

    public static function setPath($path)
    {
        self::$path = $path;
    }

    public static function setLayout($layout)
    {
        self::$layout = $layout;
    }

    public static function renderView($data = '')
    {
        $router = App::getRouter();
        if (!$router) {
            return false;
        }

        if ($router->isAdmin()) {
            $controllerDir = str_replace('Admin',DS.'admin', str_replace('Controller', '', $router->getController()));
        } else {
            $controllerDir = str_replace('Controller', '', $router->getController());
        }
        $templateName = $router->getMethodPrefix().$router->getAction().'.phtml';

        if (self::$path) {
            $path = VIEW_PATH.DS.$controllerDir.DS.$path.'.phtml';
        } else {
            $path = VIEW_PATH.DS.$controllerDir.DS.$templateName;
        }

        if (self::$layout) {
            $layout = VIEW_PATH.DS.self::$layout.'.phtml';
        } elseif ($router->isAdmin()) {
            $layout = VIEW_PATH.DS.'adminv2.phtml';
        } else {
            $layout = VIEW_PATH.DS.$router->getRoute().'.phtml';
        }

        ob_start();
        include ($path);
        $content = ob_get_clean();
        include ($layout);
        $page = ob_get_clean();
        echo $page;
        die;
    }
}