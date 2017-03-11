<?php
class App
{
    protected static $router;

    protected static $db;

    /**
     * @return Router
     */
    public static function getRouter()
    {
        return self::$router;
    }

    /**
     * @return Db
     */
    public static function getDb()
    {
        return self::$db;
    }

    public static function run($uri)
    {
        self::$router = new Router($uri);

        self::$db = new DB(
            Config::get('db.host'),
            Config::get('db.user'),
            Config::get('db.password'),
            Config::get('db.db_name')
        );

        Lang::load(self::getRouter()->getLanguage());

        $controllerClass = ucfirst(self::$router->getController()).'Controller';
        $controllerMethod = strtolower(self::$router->getMethodPrefix().self::$router->getAction());

        // call controller method
        if (class_exists($controllerClass)) {
            $controllerObject = new $controllerClass;
            if (method_exists($controllerObject, $controllerMethod)) {
                $controllerObject->$controllerMethod();
            } else {
                throw new Exception('Method "'.$controllerClass.'->'.$controllerMethod.'" does not exist');
            }
        } else {
            self::$router->setController('error');
            View::renderView('', '', '404');
        }

        // the layout render will be move to View and Controller Action
    }
}