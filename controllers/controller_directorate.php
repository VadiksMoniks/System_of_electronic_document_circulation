<?php

    class Controller_Directorate extends Controller{
        
        public function __construct()
        {
            $this->view = new View();
            $this->model = new Model_Directorate();
        }

        public function action_index()//done
        {
            $this->view->generate('directorate_template_view.php', 'account');
        }

        public function action_signIn()//done
        {
            $this->view->generate('directorate_template_view.php', 'signIn');
        }

        public function action_logIn()//done
        {
            echo $this->model->signIn($_POST);
        }

        public function action_logOut()//done
        {
            $this->model->signOut(model::DIRECTORATE);
        }

        public function action_for_signature()
        {
            $data = $this->model->documents_for_signature($_GET['u']);
            $this->view->generate('directorate_template_view.php','for_signature', $data);
        }

        public function action_sign()
        {
            $data = $this->model->showDoc($_GET['d']);
            $this->view->generate('directorate_template_view.php', 'sign', $data); 
        }

        public function action_signDoc()
        {
            echo $this->model->signDocument($_POST, $_SESSION['directorate']);
        }
    }

?>