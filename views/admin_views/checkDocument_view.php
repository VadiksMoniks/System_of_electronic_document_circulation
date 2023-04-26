<?php
    if(!$_SESSION['admin']){
        header('Location:http://localhost/System_of_electronic_document_circulation/index.php/admin/authorization');
    }
    echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin">main</a>';
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
<div id="doc"><img src="http://localhost/System_of_electronic_document_circulation/<?php echo $data;?>"></div>
<button id="delete">Delete the document</button>
<form>
    <textarea id="message"></textarea>
    <button id="deleteDoc">Delete the document</button>
</form>
    <button id="checkDoc">Checked</button>
<script>
    $(document).ready(function(){

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
                    data = JSON.parse(data);
                    $('#info').html(data.answer);
                    if($('#info').text()==="Reasone of deletion must be on ukrainian language"){
                        $('form').css("display", "block");
                    }
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
                    data = JSON.parse(data);
                    $('#info').html(data.answer);
                }
            });

        });
    
    });
</script>