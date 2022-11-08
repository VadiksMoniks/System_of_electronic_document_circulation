<?php

    //session_start();
    if(isset($_COOKIE['username'])){
        header("Location:http://localhost/System_of_electronic_document_circulation/index.php/account/account");
    }
?>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<form>
    <input type="text" placeholder="e-mail" id="mail"><br>
    <input type="password" placeholder="password" id="password"><br> 
    <button id="signin">Sign In</button>
    <p id="answer"></p>
</form>

<script>

    $(document).ready(function(){
        $(document).on('click', '#signin', function(event){
            event.preventDefault()
            var mail = $('#mail').val();
            var password = $('#password').val();

            $.ajax({
                type: "POST",
                url: 'http://localhost/System_of_electronic_document_circulation/index.php/account/logIn',
                data:{mail:mail, password:password},
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