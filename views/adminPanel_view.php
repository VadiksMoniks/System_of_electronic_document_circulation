<?php

    if($_COOKIE['root']){
        echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/logOut" id="out">log out</a>';
    }
    else{
        header('Location:http://localhost/System_of_electronic_document_circulation/index.php/admin/authorization');
    }

?>

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<p>hello</p>
<div id="list"></div>

<script>
    $(document).ready(function(){
        
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/admin/documentsList',
                data:{},

                success:function(data){
                    $('#list').fadeIn();
                    $('#list').html(data);
                }
        });



        
        // 
    });      
            
</script>

