<?php
class Router
{
    protected $uri;

    protected $controller;

    protected $action;

    protected $params;

    protected $route;

    protected $methodPrefix;

    protected $language;

    protected $isAdmin;

    public function __construct($uri)
    {
        $this->uri = urldecode(trim($uri, '/'));
        // Get defaults
        $routes = Config::get('routes');
        $this->route = Config::get('default_route');
        $this->methodPrefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->language = Config::get('default_language');
        $this->controller = Config::get('default_controller');
        $this->action = Config::get('default_action');
        $this->isAdmin = false;

        $uriParts = explode('?', $this->uri);
        // Get path like controller/action/param1/param2
        $path = $uriParts[0];
        $pathParts = explode('/', $path);

        // Get route or language at first element
        if (count($pathParts)) {
            // admin
            if (in_array(strtolower(current($pathParts)), array_keys($routes))) {
                $this->route = strtolower(current($pathParts));
                if ($this->route == Config::get('route_admin')) {
                    $this->isAdmin = true;
                    $this->controller = Config::get('default_admin_controller');
                    $this->controller .= 'Admin';
                }
                //$this->methodPrefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
                array_shift($pathParts);
            } elseif (in_array(strtolower(current($pathParts)), Config::get('languages'))) {
                $this->language = strtolower(current($pathParts));
                array_shift($pathParts);
            }
        }

        // Get controller - seoond element
        if (current($pathParts)) {
            if ($this->isAdmin) {
                $this->controller = strtolower(current($pathParts)).'Admin';
            } else {
                $this->controller = strtolower(current($pathParts));
            }

            array_shift($pathParts);
        }

        // Get action
        if (current($pathParts)) {
            $this->action = strtolower(current($pathParts));
            array_shift($pathParts);
        }

        // get Params
        $this->params = $pathParts;
    }

    /**
     * @return string
     */
    public function getMethodPrefix()
    {
        return $this->methodPrefix;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }



    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    public function setController($controller)
    {
        return $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    public static function redirect($location)
    {
        header('Location: '.$location);
        die;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }
}