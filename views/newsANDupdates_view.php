<?php
    include 'languages.php';
    if(empty($_COOKIE['lang'])){
        setcookie('lang', 'en',strtotime( '+30 days' ) ,'/');
    }
     $lang = $_COOKIE['lang'];
?>

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<!DOCTYPE html>
<html>
    <head>
        <tittle></tittle>
        <link href="http://localhost/System_of_electronic_document_circulation/styles/newsANDupdates.css" rel="stylesheet" type="text/css" />
        </head>
    
<body>
<p id="header">Future updates</p>
 <div id="blog">

 </div>
</body>
</html>
<script>
        $(document).ready(function(){
        
           

            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/newsANDupdates/readBlog',
                data:{},

                success:function(data){
                    $('#blog').html(data);
                    console.log(data);
                }
            });

        });
</script>