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
    if(!isset($view)){
        if(isset($_SERVER['PATH_INFO'])){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/directorate_views/'.trim($_SERVER['PATH_INFO'], '/').'_view.php';
        }
        else{
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/views/main_view.php';
        }
    }
    else{
        include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/directorate_views/'.$view.'_view.php';
    }
?>
</body>
</html>