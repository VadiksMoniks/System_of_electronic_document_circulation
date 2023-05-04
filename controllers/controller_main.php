<?php

    use Core\Controller;
    use Core\View;

    class Controller_Main extends Core\Controller{

        public function __construct()
        {
            $this->view = new Core\View();
        }


        public function action_index(){
            $this->view->generate('template_view.php');
        }

        public function action_changeLang(){
            if(!empty($_POST['lang'])){
               setcookie('lang', $_POST['lang'],strtotime( '+30 days' ) ,'/');
            }
        }


    }

?>