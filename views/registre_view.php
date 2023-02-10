
<?php

    //session_start();
    //setcookie('username', 'ttt', 1);
    //var_dump($_COOKIE);
    if(isset($_SESSION['user'])){
        header("Location:http://localhost/System_of_electronic_document_circulation/index.php/account/account");
    }
    $lang = $_COOKIE['lang'];
       // <input type="file" name="seal" id="seal">
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

    <form id="form">
        <input type="text" placeholder="e-mail" id="mail"><br>
        <input type="text" placeholder="username" id="username"><br>
        <input type="password" placeholder="password" id="password"><br>
        <button value="reg" id="reg">Registrate</button><br>
        <p id="answer"></p>
        
    </form>
</div>
</body>
</html>
<script>
 $(document).ready(function(){
    $(document).on('click', '#reg', function(event){
        event.preventDefault()
        //function uploadfiles(){
            var form = $('#form');
            var mail = $('#mail').val();
            var username = $('#username').val();
            var password = $('#password').val();
            var keepSigned = '';
          //  if($('#check').is(":checked")){
           //        keepSigned = 'keep';
           //     }
           // else{
           //     keepSigned = 'no';
           //     }
            /*if($('#stud').val()=="on"){
                 = 'student';
            }
            else{
                var status = 'teacher'; 
            }
            console.log(status);*/
            //var filename = $('#signature').val();
            //var sigData = $('#signature').prop('files')[0];
            //var form_data = new FormData(form[3]);
            //form_data.append("file", form_data);
            //form_data_sig.append("filename",filename);
            //var http = new XMLHttpRequest();
            //http.upload.addEventListener()
            //console.log(form_data);
         /*   if($('status').val()=="teach"){
                var sealData = $('#signature').prop('files')[0];
                var form_data_seal = new FormData();
                form_data_sig.append("file", sealData);
            }*/
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/account/regMe',
                data:{mail:mail, username:username, password:password},
                //cache: false,
                //contentType: false,
                //processData: false,
                
                success:function(data){
                        $('#answer').fadeIn();
                        $('#answer').html(data);
                        console.log($('#answer').val());
                        if(data == "OK"){
                            location.reload();
                        }
                }
            });
    });
});

</script>