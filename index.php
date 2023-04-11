<?php
    ini_set('display_errors', 1);
    mb_internal_encoding("UTF-8");
    error_reporting(E_ALL);
    include 'core/model.php';
    include 'core/view.php';
    include 'core/controller.php';
    include 'core/router.php';
    //include 'languages.php';
    Router::start();
    //$lang = 'en';
?>