<?php
//session_start();
if(!isset($_SESSION['user'])){
    header("Location: http://localhost/System_of_electronic_document_circulation/index.php");
}
if(isset($_COOKIE['lang'])){
    $lang = $_COOKIE['lang'];
}
else{
   $lang = 'en'; 
}
?>
<?php   echo '<p>'.$_SESSION['user'].'</p>';?>
<ul id="docsList">
    <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/history_list?u=<?php echo $_SESSION['user']?>"><?php echo $$lang['history.acc'];?></a></li>
    <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/documents_to_download?u=<?php echo $_SESSION['user']?>"><?php echo $$lang['download.acc'];?></a></li>
    <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/for_signature?u=<?php echo $_SESSION['user']?>"><?php echo $$lang['sign.acc'];?></a></li>
</ul>


<p>Settings</p>
<ul>
    <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/changePasswordForm">change password</a></li>
</ul>
<?php
   // session_start();
   //var_dump($_COOKIE);
       echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/account/logOut" id="out">'.$$lang['out.acc'].'</a>';
 

?>
<p>Settings</p>
<ul>
    <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/changePasswordForm">Change e-mail</a></li>
</ul>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<style>
    .docsList{
        
    }
    #out{
        font-size: 30px;;
    }
</style>