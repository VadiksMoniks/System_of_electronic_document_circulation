<?php


    class Controller_Account extends Controller{

        public function __construct()
        {
            $this->view = new View();
            $this->model = new Model_Account();
        }


        public function action_signIn(){

            $this->view->generate('template_view.php');

        }

        public function action_login(){
            echo $this->model->signIn($_POST, $_COOKIE['lang']);
            
        }

        public function action_registre(){

            $this->view->generate('template_view.php');

        }

        public function action_regMe(){
             //echo $_POST['username'];
             echo $this->model->registre($_POST, $_COOKIE['lang']);

            
        }

        public function action_account(){

            $this->view->generate('template_view.php');

        }

        public function action_changePasswordForm(){
            $this->view->generate('template_view.php');
        }

        public function action_change_password(){
            echo $this->model->changePass($_POST);
        }

        public function action_documents_to_download(){
            $this->view->generate('template_view.php');
        }

        public function action_download(){
            echo $this->model->downloadBlank($_GET['name']);
        }

        public function action_docList(){
            echo $this->model->dwnlist($_POST['user'],$_COOKIE['lang']);
        }

        public function action_deleteDoc(){
            echo $this->model->deleteDocument($_POST['docName'],$_COOKIE['lang']);
        }

        public function action_history(){
            echo $this->model->historyList($_POST['user'],$_COOKIE['lang']);
        }

        public function action_history_list(){
            $this->view->generate('template_view.php');
        }

        public function action_for_signature(){
            $this->view->generate('template_view.php');
        }

        public function action_sign(){
            $this->view->generate('template_view.php');
        }

        public function action_docs_for_sign(){
            echo $this->model->signList($_POST['user'],$_COOKIE['lang']);
        }

        public function action_show(){
            echo $this->model->show_doc($_POST['docName'],$_COOKIE['lang']);
        }

        /*function action_sign_document(){
            $this->model->signDoc($_POST['docName']);
        }*/

        public function action_signDoc(){
            echo $this->model->sign_document($_POST['docName'],$_COOKIE['lang']);
        }

        public function action_logOut(){
            $this->model->signOut();
            
        }

        public function action_showDoc(){
            echo $this->model->show_doc($_GET['name'],$_COOKIE['lang']);
        }
    }

?>