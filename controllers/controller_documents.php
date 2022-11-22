<?php

    class Controller_Documents extends Controller{

        function __construct()
        {
            $this->view = new View();
            $this->model = new Model_Documents();
        }

        function action_document(){
            $this->view->generate('document_view.php', 'template_view.php');
        }


        function action_generate(){
            echo $this->model->generateDoc($_POST, $_COOKIE['lang']);
        }

      /*  function action_download(){
            echo $this->model->downloadBlank($_GET['name']);
        }
     */
        function action_formating(){
            $this->view->generate('formating_view.php', 'template_view.php');
        }

        function action_showExample(){
            return "E:/xampp/htdocs/System_of_electronic_document_circulation/ticket.png";
        }

        /*function action_downloadExample(){
            $this->model->downloadExample($_GET['name']);
        }*/

    }

?>