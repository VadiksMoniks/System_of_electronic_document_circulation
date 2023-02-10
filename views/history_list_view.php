<div id="answer">

</div>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <script>
    $(document).ready(function(){

        var user = '<?php echo $_SESSION['user'];?>';

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
            var data = new FormData;
            var docName = $(this).val();
            var user = '<?php echo $_SESSION['user'];?>'
            data.append('docName', docName);
            data.append('user', user);
            //console.log(docName);
            
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/account/deleteDoc',
                data:data,
                contentType : false,
                processData: false,
                
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