<?php
class Controller
{
    protected $data;

    protected $model;

    protected $params;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    public function __construct($data = array())
    {
        $router = App::getRouter();

        $this->data = $data;
        $this->params = $router->getParams();

        $controllerMethod = strtolower($router->getMethodPrefix().$router->getAction());
        if ($router->isAdmin()) {
            if (Session::get('role') != 'admin') {
                if ($controllerMethod != 'login') {
                    Router::redirect(getAdminUrl('user/login'));
                }
            }
        }
    }

    public function cleanInput($input)
    {
        $input = trim($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input);

        return $input;
    }
}