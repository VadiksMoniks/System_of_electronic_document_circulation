<?php

    if(!isset($_SESSION['directorate'])){
        header('Location:http://localhost/System_of_electronic_document_circulation/index.php/');
    }

    for($i=0; $i<count($data); $i++)
    {
        echo "<a href='http://localhost/System_of_electronic_document_circulation/index.php/directorate/sign?d=".$data[$i]."'>".$data[$i]."</a></br>";
    }
?>

