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
    <!--<li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/for_signature?u=<?php //echo $_SESSION['user']?>"><?php //echo $$lang['sign.acc'];?></a></li>-->
</ul>


<p><?php echo $$lang['account.settings'];?></p>
<ul>
    <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/changePasswordForm"><?php echo $$lang['account.changePass'];?></a></li>
</ul>
<div>
    <p id="status"></p>
    <button id="change">change setting</button>
    <p id="answer"></p>
</div>
<?php
   // session_start();
   //var_dump($_COOKIE);
       echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/account/logOut" id="out">'.$$lang['out.acc'].'</a>';
 

?>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <script>

$(document).ready(function(){
    let user = '<?php echo $_SESSION['user'];?>';
    $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/account/notificationStatus',
                data:{user:user},
                
                success:function(data){
                    console.log(data);
                        if(data == '1'){
                            $('#status').html("You'r getting notifications from us");
                        }
                        else{
                            $('#status').html("You'r NOT getting notifications from us");
                        }
                       
                }
            });
            $(document).on('click', '#change', function(event){
                event.preventDefault()
                $.ajax({
                    type:'POST',
                    url:'http://localhost/System_of_electronic_document_circulation/index.php/account/notification',
                    data:{user:user},
                    //cache: false,
                    //contentType: false,
                    //processData: false,
                    
                    success:function(data){
                        $('#answer').html(data);
                        $('#answer').fadeIn();
                            console.log(data);
                    }
                });
            });
    
});

  </script>
<style>
    .docsList{
        
    }
    #out{
        font-size: 30px;;
    }
</style>