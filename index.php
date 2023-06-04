<?php
    ini_set('display_errors', 1);
    mb_internal_encoding("UTF-8");
    error_reporting(E_ALL);
    require 'core/model.php';
    require 'core/view.php';
    require 'core/controller.php';
    require 'core/router.php';
    //include 'languages.php';
    Router::start();
    //$lang = 'en';
?>