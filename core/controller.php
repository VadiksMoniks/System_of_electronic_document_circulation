<?php
    
    namespace Core;
    
    abstract class Controller{

        protected $view;
        protected $model;

       // function __construct()
       // {
       //     $this->view = new View();
       // }

        abstract public function action_index();

    }
