<style>
    form{
        display: none;
    }
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
    
    });
</script>