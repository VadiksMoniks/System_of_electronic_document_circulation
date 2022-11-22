<?php

    //session_start();
    if(isset($_COOKIE['username'])){
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
        <a href='http://localhost/System_of_electronic_document_circulation/index.php/account/signIn' class="text"><?php  echo $$lang['signInLink'];?></a>
        <form>
            <input type="text" placeholder="e-mail" id="mail"><br>
            <input type="password" placeholder="password" id="password"><br> 
            <input type="checkbox" id="check"></br>
            <label >Keep me signed in</label>
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
            if($('#check').is(":checked")){
                   keepSigned = 'keep';
                }
            else{
                keepSigned = 'no';
                }
            $.ajax({
                type: "POST",
                url: 'http://localhost/System_of_electronic_document_circulation/index.php/account/logIn',
                data:{mail:mail, password:password, keepSigned:keepSigned},
                success:function(data){
                        $('#answer').fadeIn();
                        $('#answer').html(data);
                        console.log(data);
                        if(data == "OK"){
                            location.reload();
                        }
                        
                }
            })
        });
    });

</script>