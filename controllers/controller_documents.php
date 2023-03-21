<?php

    class Controller_Documents extends Controller{

        public function __construct()
        {
            $this->view = new View();
            $this->model = new Model_Documents();
        }

        public function action_document(){
            $this->view->generate('template_view.php');
        }


        public function action_generate(){
            echo $this->model->generateDoc($_POST, $_COOKIE['lang']);
        }

        public function action_formating(){
            $data = $this->model->showExample($_GET['name']);
            echo $this->view->generate('template_view.php', $data);
        }

        public function action_handwritten(){
            $data = $this->model->showExample($_GET['name']);
            echo $this->view->generate('template_view.php', $data);
        }

       // public function action_showExample(){
       //     echo $this->model->showExample($_POST['name']);
       // }

        public function action_getList(){
            echo $this->model->recipientList($_POST['recipientName']);
        }

        /*function action_downloadExample(){
            $this->model->downloadExample($_GET['name']);
        }*/

    }

?>