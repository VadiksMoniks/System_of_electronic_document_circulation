<!DOCTYPE html>
<html>
    <head>
        <tittle></tittle>
    </head>
    <link href="http://localhost/System_of_electronic_document_circulation/styles/404_page.css" rel="stylesheet" type="text/css" />
    <body>
<?php
include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
    if(!isset($_COOKIE['lang'])){
        setcookie('lang', 'en',strtotime( '+30 days' ) ,'/');
    }
    $lang= $_COOKIE['lang'];

    echo "<p id='header'>Page not found</p></br>";
    echo "<p id='text'>Looks like something went wrong</p></br>";
    echo '<div id="btn"><a href="http://localhost/System_of_electronic_document_circulation/index.php/main">'.$$lang['goHome'].'</a></div>'

?>
</body>
</html>