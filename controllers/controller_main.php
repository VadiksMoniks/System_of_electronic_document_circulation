<?php

    class Controller_Main extends Controller{

        function __construct()
        {
            $this->view = new View();
        }


        function action_index(){
            $this->view->generate('main_view.php', 'template_view.php');
        }

        function action_changeLang(){
            if(!empty($_POST['lang'])){
               setcookie('lang', $_POST['lang'],strtotime( '+30 days' ) ,'/');
            }
        }
    }

?>