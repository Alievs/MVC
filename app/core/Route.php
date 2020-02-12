<?php

class Route
{
    public static function buildRoute()
    {
        //controller and action by default
        $controllerName = "MainController";
        $modelName = "MainModel";
        $action = "index";

        //parse url (only part of url)
        $route = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        //checks url from the end
        $i = count($route)-1;

        while($i > 0) {
            if($route[$i] != '') {
                /*                 define controller  & GET parameter */
                if(is_file(CONTROLLER_PATH . ucfirst($route[$i]) . "Controller.php") || !empty($_GET)) {
                    $controllerName = ucfirst($route[$i]) . "Controller";
                    $modelName =  ucfirst($route[$i]) . "Model";
                    break;
                } else {
                    //take action
                    $action = $route[$i];
                }
            }
            $i--;
        }



        //check if exist & connect controller OR Page404
        self::controllerCheck($controllerName);
        //check if exist & connect model
        self::modelCheck($modelName);

        $controller = new $controllerName();

        if(method_exists($controller, $action)) {
            // call controller action
            $controller->$action();
        }
        else {
            // Without exception just redirect
            Route::ErrorPage404();
        }

    }

    static function controllerCheck($controllerName)
    {
        $controllerPath = CONTROLLER_PATH . $controllerName . ".php";

        if(file_exists($controllerPath)) {
            require_once $controllerPath;
        }
        else {
            //Without exception just redirect
            self::ErrorPage404();
        }
    }

    static function modelCheck($modelName)
    {
        $modelPath = MODEL_PATH . $modelName . ".php";
        if(file_exists($modelPath))
        {
            require_once $modelPath;
        }        else {
            //Without exception just redirect
            self::ErrorPage404();
        }
    }

    static function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}