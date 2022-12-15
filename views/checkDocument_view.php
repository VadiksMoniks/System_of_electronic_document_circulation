<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<div id="doc"></div>

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
    
    });
</script>