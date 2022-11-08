<?php
include 'E:/xampp/htdocs/System_of_electronic_document_circulation/models/model_account.php';
    class Controller_Registre extends Controller{

        function __construct()
        {
            $this->view = new View();
            $this->model = new Model_Account();
        }

        function action_registre(){
           echo $this->model->registre($_POST);
        }

    }

    //$c = new Controller_Registre();
    //$c->action_registre();

?>