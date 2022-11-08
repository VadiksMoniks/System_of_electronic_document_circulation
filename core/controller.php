<?php

    class Controller{

        protected $view;
        protected $model;

        function __construct()
        {
            $this->view = new View();
        }

        function action_index()
        {

        }

    }

?>