<div id="answer">

</div>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <script>
    $(document).ready(function(){

        var user = '<?php echo $_COOKIE['username'];?>';

        $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/account/history',
                data:{user:user},
                success:function(data){
                    $('#answer').html(data);
                }
            });

        $(document).on('click', '.btn', function(event){
            event.preventDefault();

            var docName = $('.btn').val();
            console.log($('.btn').val());
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/account/deleteDoc',
                data:{docName:docName},
                success:function(data){
                    $('#answer').html(data);
                    if(data==='Document was deleted' || data==='Документ було видалено'){
                        location.reload();
                    }
                }
            });
        });

    });
    
    

  </script>