<?php
    if(!$_SESSION['admin']){
        header('Location:http://localhost/System_of_electronic_document_circulation/index.php/admin/authorization');
    }
    echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/adminPanel">main</a>';
?>

<style>
    form{
        display: none;
    }
    
    #doc{
    
              margin-left:30%;  
              width: 600px;
              height: 800px;
                border: 5px solid;
                border-color: #000;
    }
    img { width: auto; height: 100%; }
</style>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<p id="info"></p>
<div id="doc"></div>
<button id="delete">Delete the document</button>
<form>
    <textarea id="message"></textarea>
    <button id="deleteDoc">Delete the document</button>
</form>
    <button id="checkDoc">Checked</button>
<script>
    $(document).ready(function(){
        docName = '<?php echo $_GET['n'];?>';
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/admin/showDocument',
                data:{docName:docName},

                success:function(data){
                    $('#doc').fadeIn();
                    $('#doc').html(data);
                }
        });

        $(document).on('click', '#delete', function(event){
            event.preventDefault();
            $('form').css("display", "block");
             $('#delete').css("display", "none");
            

        });

        $(document).on('click', '#deleteDoc', function(event){
            event.preventDefault();
            $('form').css("display", "none");

            var docName = '<?php echo $_GET['n'];?>';
            var message = $('#message').val();
            
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/admin/manipulate',
                data:{docName:docName, message:message},

                success:function(data){
                    $('#info').html(data);
                }
            });

        });

        $(document).on('click', '#checkDoc', function(event){
            event.preventDefault();

            var docName = '<?php echo $_GET['n'];?>';
            
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/admin/checked',
                data:{docName:docName},

                success:function(data){
                    $('#info').html(data);
                }
            });

        });
    
    });
</script>