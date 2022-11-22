<?php


    class Controller_Account extends Controller{

        function __construct()
        {
            $this->view = new View();
            $this->model = new Model_Account();
        }


        function action_signIn(){

            $this->view->generate('signIn_view.php', 'template_view.php');

        }

        function action_login(){
            echo $this->model->signIn($_POST, $_COOKIE['lang']);
            
        }

        function action_registre(){

            $this->view->generate('registre_view.php', 'template_view.php');

        }

        function action_regMe(){
             //echo $_POST['username'];
             echo $this->model->registre($_POST, $_COOKIE['lang']);

            
        }

        function action_account(){

            $this->view->generate('account_view.php', 'template_view.php');

        }

        function action_documents_to_download(){
            $this->view->generate('downloadPage_view.php','template_view.php');
        }

        function action_download(){
            echo $this->model->downloadBlank($_GET['name']);
        }

        function action_docList(){
            echo $this->model->dwnlist($_POST['user'],$_COOKIE['lang']);
        }

        function action_deleteDoc(){
            echo $this->model->deleteDocument($_POST['docName'],$_COOKIE['lang']);
        }

        function action_history(){
            echo $this->model->historyList($_POST['user'],$_COOKIE['lang']);
        }

        function action_history_list(){
            $this->view->generate('history_view.php','template_view.php');
        }

        function action_for_signature(){
            $this->view->generate('for_signature_view.php', 'template_view.php');
        }

        function action_sign(){
            $this->view->generate('sign_view.php', 'template_view.php');
        }

        function action_docs_for_sign(){
            echo $this->model->signList($_POST['user'],$_COOKIE['lang']);
        }

        function action_show(){
            echo $this->model->show_doc($_POST['docName'],$_COOKIE['lang']);
        }

        /*function action_sign_document(){
            $this->model->signDoc($_POST['docName']);
        }*/

        function action_signDoc(){
            echo $this->model->sign_document($_POST['docName'],$_COOKIE['lang']);
        }

        function action_logOut(){
            $this->model->signOut();
        }
    }

?>