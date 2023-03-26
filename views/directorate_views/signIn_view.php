<?php

if(isset($_SESSION['directorate'])){
        header('Location:http://localhost/System_of_electronic_document_circulation/index.php/directorate/account');
    }

?>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<div id="formDiv">
        <form>
            <input type="text" placeholder="e-mail" id="mail"><br>
            <input type="password" placeholder="password" id="password"><br> 
            <button id="signin">Sign In</button>
            <p id="answer"></p>
        </form>
    </div> 
    
    <script>

    $(document).ready(function(){
        $(document).on('click', '#signin', function(event){
            event.preventDefault()
            var mail = $('#mail').val();
            var password = $('#password').val();
            var keepSigned = '';
            $.ajax({
                type: "POST",
                url: 'http://localhost/System_of_electronic_document_circulation/index.php/directorate/logIn',
                data:{mail:mail, password:password},
                success:function(data){
                        $('#answer').fadeIn();

                        data = JSON.parse(data);
                        $('#answer').html(data.answer);
                        //
                        if(data.answer == "OK"){
                            location.reload();
                        }
                        
                }
            })
        });
    });

</script>