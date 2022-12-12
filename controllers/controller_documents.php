<?php

    class Controller_Documents extends Controller{

        public function __construct()
        {
            $this->view = new View();
            $this->model = new Model_Documents();
        }

        public function action_document(){
            $this->view->generate('document_view.php', 'template_view.php');
        }


        public function action_generate(){
            echo $this->model->generateDoc($_POST, $_COOKIE['lang']);
        }

        public function action_formating(){
            $this->view->generate('formating_view.php', 'template_view.php');
        }

        public function action_showExample(){
            return "E:/xampp/htdocs/System_of_electronic_document_circulation/ticket.png";
        }

        public function action_getList(){
            echo $this->model->recipientList($_POST['recipientName']);
        }

        /*function action_downloadExample(){
            $this->model->downloadExample($_GET['name']);
        }*/

    }

?>