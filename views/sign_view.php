<p id="result"></p>
<div id="answer">

</div>
<form enctype="multipart/form-data">
    <input type="file" id="signature"><br/>
    <button id="sign">sign</button>
</form>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <script>
    $(document).ready(function(){
        var docName = '<?php echo $_GET['name'];?>';

        $.ajax({
            type:'POST',
            url:'http://localhost/System_of_electronic_document_circulation/index.php/account/show',
            data:{docName:docName},
            success:function(data){
                $('#answer').html(data);
            }
        });

        $(document).on('click', '#sign', function(event){
            event.preventDefault();
            var img = $('#signature').prop('files')[0];
            var docName = '<?php echo $_GET['name'];?>';
            var data = new FormData;
            data.append('file', img);
            data.append('docName', docName);
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/account/signDoc',
                data:data,
                contentType : false,
                processData: false,

                success:function(data){
                    //$('#dwnld').attr('href', 'http://localhost/System_of_electronic_document_circulation/index.php/documents/download?name='+data); 
                    $('#result').html(data);
                }
            });
        });
    });
    
    //console.log(user);

  </script>