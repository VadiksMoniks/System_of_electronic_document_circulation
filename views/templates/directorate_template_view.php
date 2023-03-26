<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

?>
<!DOCTYPE html>
<html>
    <head>
        <tittle></tittle>
    </head>
    
<body>
    <h1>directorate template</h1>
<?php
   /* if(isset($_SESSION['directorate'])){
        echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/directorate/signIn">Sign In</a>';
    }
    else{
        echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/directorate/logOut">Log Out</a>';
    }*/

    if(file_exists('E:/xampp/htdocs/System_of_electronic_document_circulation/views/directorate_views/'.basename($_SERVER['PATH_INFO']).'_view.php')){
        include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/directorate_views/'.basename($_SERVER['PATH_INFO']).'_view.php';
    }
    else{
        include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/404_view.php';
    }
?>
</body>
</html>