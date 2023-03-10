<?php

    //session_start();
    if(isset($_SESSION['user'])){
        header("Location:http://localhost/System_of_electronic_document_circulation/index.php/account/account");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="http://localhost/System_of_electronic_document_circulation/styles/reg_sign.css" rel="stylesheet" type="text/css" />
        <tittle></tittle>
    </head>
    <body>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

    <div id="formDiv">
        <p class="text"><?php  echo $$lang['goSignIn.reg'];  ?></p>
        <a href='http://localhost/System_of_electronic_document_circulation/index.php/account/registre' class="text"><?php  echo $$lang['registreLink'];?></a>
        <form>
            <input type="text" placeholder="e-mail" id="mail"><br>
            <input type="password" placeholder="password" id="password"><br> 
            <button id="signin">Sign In</button>
            <p id="answer"></p>
        </form>
    </div>  
</body>
</html>
<script>

    $(document).ready(function(){
        $(document).on('click', '#signin', function(event){
            event.preventDefault()
            var mail = $('#mail').val();
            var password = $('#password').val();
            var keepSigned = '';
            $.ajax({
                type: "POST",
                url: 'http://localhost/System_of_electronic_document_circulation/index.php/account/logIn',
                data:{mail:mail, password:password},
                success:function(data){
                        $('#answer').fadeIn();
                        data = JSON.parse(data);
                        $('#answer').html(data.answer);
                        console.log(data);
                        if(data.answer == "OK"){
                            location.reload();
                        }
                        
                }
            })
        });
    });

</script>