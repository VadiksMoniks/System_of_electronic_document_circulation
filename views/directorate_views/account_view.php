<?php

    if(!isset($_SESSION['directorate'])){
        header('Location:http://localhost/System_of_electronic_document_circulation/index.php/directorate/signIn');
    }

?>
<h1>acc</h1>
<!--<a href="http://localhost/System_of_electronic_document_circulation/index.php/directorate/for_signature?u=<?php echo $_SESSION['directorate'];?>">docst</a>-->
<a href="http://localhost/System_of_electronic_document_circulation/index.php/directorate/logOut">log out</a>
<h1>Список документів на підпис</h1>
<?php

    for($i=0; $i<count($data); $i++)
    {
        echo "<a href='http://localhost/System_of_electronic_document_circulation/index.php/directorate/sign?d=".$data[$i]."'>".$data[$i]."</a></br>";
    }

?>