<?php

    class Controller_Documents extends Controller{

        function __construct()
        {
            $this->view = new View();
            $this->model = new Model_Documents();
        }

        function action_document_list(){
            $this->view->generate('document_view.php', 'template_view.php');
        }

        function action_getExample(){
            echo $this->model->getExample($_POST['example']);
        }

        function action_generate(){
            echo $this->model->generateDoc($_POST);
        }

      /*  function action_download(){
            echo $this->model->downloadBlank($_GET['name']);
        }
     */
        function action_formating(){
            $this->view->generate('formating_view.php', 'template_view.php');
        }

    }

?>