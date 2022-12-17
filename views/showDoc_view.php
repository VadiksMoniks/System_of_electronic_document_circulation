<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<div id="answer"></div>
<p>asfasfas</p>
<script>
    $(document).ready(function(){
        var docName = '<?php echo $_GET['name'];?>';

        $.ajax({
            type:'POST',
            url:'http://localhost/System_of_electronic_document_circulation/index.php/account/showDoc',
            data:{docName:docName},
            success:function(data){
                $('#answer').html(data);
            }
        });
    });
</script>