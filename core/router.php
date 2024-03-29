<?php

    class Router{

        public static function start(){

            $controller_name = 'Main';
            $action_name = 'index';
            $model_name = '';


            if(isset($_SERVER['PATH_INFO'])){
                if($_SERVER['PATH_INFO']=='/'){
                    header('Location: http://localhost/System_of_electronic_document_circulation/index.php/main'); 
                }
                $routes = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            }
            
            else{
                header('Location: http://localhost/System_of_electronic_document_circulation/index.php/main');
            }

            if(!empty($routes[4])){

                if(preg_match('/\?\w/', $routes[4])==1){

                    $check_get = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY);
                    $getParam = explode('=',$check_get);
                   /* if(preg_match('/[&]/', $check_get)==true){ FOR FEW PARAMS!!!!!!!!!!!!!!!!!!!!!!
                    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                        $query_temp = explode('&', $check_get); // Разбиваем _GET запрос в массив
                        $query = array(); // Задаем пустой массив для будущего вывода

                        // Перебираем массив с GET запросом
                        foreach($query_temp as $key=>$value) {
                            $temp = explode('=', $value); // Разбиваем каждый запрос через знак =
                            $query[$temp['0']] = $temp['1'];
                        } 
                    }*/

                    //else{
                      //  $getParam = $check_get['query'];
                   // }

                    $r=explode('?',$routes[4]);
                    $action_name = $r[0];
                }
                else{
                    $action_name = $routes[4];
                }
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