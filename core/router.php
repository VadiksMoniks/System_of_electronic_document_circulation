<?php

    class Router{

        public static function start(){
            
            $controller_name = 'Main';
            $action_name = 'index';
            $model_name = '';

            $routes = explode('/', trim($_SERVER['PATH_INFO'],'/'));


            if(!empty($routes[0])){
                $controller_name = $routes[0];
            }
            else{
                $controller_name = 'Main';
            }

            if(!empty($routes[1])){

                $action_name = $routes[1];

            }

            $model_name = 'Model_'.ucfirst($controller_name);
            $controller_name = 'Controller_'.ucfirst($controller_name);
            $action_name = 'action_'.$action_name;

            $model_file = strtolower($model_name).'.php';
            $model_path = 'models/'.$model_file;

            if(file_exists($model_path)){
                include $model_path;
            }

            $controller_file = strtolower($controller_name).'.php';
            $controller_path = 'controllers/'.$controller_file;

            if(file_exists($controller_path)){
                include $controller_path;
            }

            else{
                Router::ErrorPage404();
                exit;
            }

            $controller = new $controller_name;
            $action = $action_name;

            if(method_exists($controller, $action)){

                    $controller->$action();

           }

           else{
                Router::ErrorPage404();
            }
        }

        public static function ErrorPage404(){
           include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/404_view.php';
        }


    }

?>