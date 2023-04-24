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
        public function action_makeHandwritten()
        {
            echo $this->model->handwrittenDoc($_POST,$_COOKIE['lang']);
        }

        public function action_getList(){
            echo $this->model->recipientList($_POST['recipientName']);
        }

        public function action_getDocuments(){
            echo $this->model->documentList($_POST['name'], $_COOKIE['lang']);
        }

    }

?>