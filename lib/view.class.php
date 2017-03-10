<?php
class View
{
    protected $data;

    protected $path;

    public function __construct($data = array(), $path = null)
    {
        if (!$path) {
            $path = self::getDefaultViewPath();
        }
        if (!file_exists($path)) {
            throw new Exception('Template file is not found in path: '.$path);
        }
        $this->path = $path;
        $this->data = $data;
    }

    protected static function getDefaultViewPath()
    {
        $router = App::getRouter();
        if (!$router) {
            return false;
        }
        $controllerDir = str_replace('Controller', '', $router->getController());
        $templateName = $router->getMethodPrefix().$router->getAction().'.phtml';

        return VIEW_PATH.DS.$controllerDir.DS.$templateName;
    }

    public function render()
    {
        $data = $this->data;
        ob_start();
        include ($this->path);
        $content = ob_get_clean();
        return $content;
    }

    public static function renderView($data = '', $layout = '', $path = '')
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

        if ($path) {
            $path = VIEW_PATH.DS.$controllerDir.DS.$path.'.phtml';
        } else {
            $path = VIEW_PATH.DS.$controllerDir.DS.$templateName;
        }

        if ($layout) {
            $layout = VIEW_PATH.DS.$layout.'.phtml';
        } elseif ($router->isAdmin()) {
            $layout = VIEW_PATH.DS.'admin.phtml';
        } else {
            $layout = VIEW_PATH.DS.$router->getRoute().'.phtml';
        }

        ob_start();
        include ($path);
        $content = ob_get_clean();
        include ($layout);
        $page = ob_get_clean();
        echo $page;
    }
}