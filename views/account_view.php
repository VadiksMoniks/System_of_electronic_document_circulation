<?php
    $lang = $_COOKIE['lang'];
?>
<ul>
    <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/history_list">documents history</a></li>
    <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/documents_to_download">download documents</a></li>
    <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/for_signature">documents for signature</a></li>
</ul>

<?php
   // session_start();
   //var_dump($_COOKIE);
    if(!isset($_COOKIE['username'])){
        header("Location: http://localhost/System_of_electronic_document_circulation/index.php/");
    }
    else{
       echo '<p>your acc</p>';
       echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/account/logOut">'.$$lang['out.acc'].'</a>';
    }

?>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

