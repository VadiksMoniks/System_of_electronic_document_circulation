<?php
    if(isset($_COOKIE['root'])){
        echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/adminPanel">main</a>';
    }
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