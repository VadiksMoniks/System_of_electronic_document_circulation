<?php

    class Router{

                    
        private static $controller_name = 'Main';
        private static $action_name = 'index';
        private static $model_name = '';

        public static function start(){

            $routes = explode('/', trim($_SERVER['REQUEST_URI'],'/'));

            if(!empty($routes[2]) && isset($routes[2])){
                self::$controller_name = $routes[2];
            }

            if(!empty($routes[3]) && isset($routes[3])){

                if(preg_match('/\?\w/', $routes[3])==1){
                    $r=explode('?',$routes[3]);
                    self::$action_name = $r[0];
                }
                else{
                    self::$action_name = $routes[3];
                }
            }  

            if(!isset($routes[3]) && strtolower(self::$controller_name)!='main'){
                Router::ErrorPage404();
            }

            self::$model_name = 'Model_'.self::$controller_name;
            self::$controller_name = 'Controller_'.self::$controller_name;
            self::$action_name = 'action_'.self::$action_name;

            $model_file = strtolower(self::$model_name).'.php';
            $model_path = 'models/'.$model_file;

            if(file_exists($model_path)){
                include $model_path;
            }

            $controller_file = strtolower(self::$controller_name).'.php';
            $controller_path = 'controllers/'.$controller_file;

            if(file_exists($controller_path)){
                include $controller_path;
            }

            else{
                Router::ErrorPage404();
                exit;
            }

            $controller = new self::$controller_name;
            $action = self::$action_name;

            if(method_exists($controller, $action)){

       /*         if($getParam!=null){
                    $controller->$action($getParam[1]);
                }
                else{*/
                    $controller->$action();
            //    / }
                
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