<!DOCTYPE html>
<html>
    <head>
        <tittle></tittle>
    </head>
    
<body>

    <form enctype="multipart/form-data">
        <input type="file" id="signature"><br/>
        <button id="sign">sign</button>
    </form>
    <div id="answer">

    </div>
</body></html>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <script>
    $(document).ready(function(){
       /* var docName = 

        $.ajax({
            type:'POST',
            url:'http://localhost/System_of_electronic_document_circulation/index.php/account/show',
            data:{docName:docName},
            success:function(data){
                $('#answer').html(data);
            }
        });*/

        $(document).on('click', '#sign', function(event){
            event.preventDefault();
            var img = $('#signature').prop('files')[0];
            var docName = '<?php echo $_GET['u'];?>';
            var data = new FormData;
            data.append('file', img);
            data.append('document_name', docName);
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/directorate/signDoc',
                data:data,
                contentType : false,
                processData: false,

                success:function(data){
                    //$('#dwnld').attr('href', 'http://localhost/System_of_electronic_document_circulation/index.php/documents/download?name='+data); 
                    $('#answer').html(data);
                }
            });
        });
    });
    
    //console.log(user);

  </script>