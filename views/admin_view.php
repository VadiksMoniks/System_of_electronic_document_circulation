<?php
  //  if(isset($_SESSION['admin'])){
        
  //  }
?>

<?php

if(!isset($_SERVER['PATH_INFO'])){
    include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/main_view.php';
}
else{
    if(file_exists('E:/xampp/htdocs/System_of_electronic_document_circulation/views/'.basename($_SERVER['PATH_INFO']).'_view.php')){
        include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/'.basename($_SERVER['PATH_INFO']).'_view.php';
    }
    else{
        echo '404';
    }
}
?>