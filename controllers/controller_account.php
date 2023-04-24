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

        public function action_changePasswordForm(){
            $this->view->generate('template_view.php');
        }

        public function action_change_password(){
            echo $this->model->change_password($_POST);
        }

        public function action_account(){
            $this->view->generate('template_view.php');

        }

        public function action_documents_to_download(){
            $data = $this->model->dwnlist($_GET['u'],$_COOKIE['lang']);
            $this->view->generate('template_view.php', $data);
        }

        public function action_download(){
            echo $this->model->downloadBlank($_GET['name']);
        }

        public function action_deleteDoc(){
            echo $this->model->deleteDocument($_POST,$_COOKIE['lang']);
        }


        public function action_history_list(){
            $data = $this->model->historyList($_GET['u'],$_COOKIE['lang']);
            $this->view->generate('template_view.php', $data);
        }


        public function action_sign(){
            $this->view->generate('template_view.php');
        }

        public function action_verificateUser(){
             echo $this->model->verificate($_POST['token'],$_COOKIE['lang']);
        }

        public function action_logOut(){
            $this->model->signOut(model::USER);
            
        }

        public function action_showDoc(){
            echo $this->model->show_doc($_GET['name'],$_COOKIE['lang']);
        }

        public function action_notificationStatus(){
            echo $this->model->notificationStatus($_POST);
        }

        public function action_notification(){
            echo $this->model->turnNotification($_POST);
        }
    }

?>