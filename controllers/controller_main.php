<?php

    class Controller_Main extends Controller{

        public function __construct()
        {
            $this->view = new View();
        }


        public function action_index(){
            $this->view->generate('main_view.php', 'template_view.php');
        }

        public function action_changeLang(){
            if(!empty($_POST['lang'])){
               setcookie('lang', $_POST['lang'],strtotime( '+30 days' ) ,'/');
            }
        }


    }

?>