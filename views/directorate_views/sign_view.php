<?php
    if(!isset($_SESSION['directorate'])){
        header('Location:http://localhost/System_of_electronic_document_circulation/index.php/directorate/signIn');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <tittle></tittle>
        <style>
            #image{
                
                margin-left:30%;  
                width: 600px;
                height: 800px;
                border: 5px solid;
                border-color: #000;
            }
            img { width: auto; height: 100%; }
        </style>
    </head>
    
<body>
    <a href="http://localhost/System_of_electronic_document_circulation/index.php/directorate?u=<?php echo $_SESSION['directorate']?>">Назад</a>
    <form enctype="multipart/form-data">
        <input type="file" id="signature"><br/>
        <button id="sign">sign</button>
    </form>
    <div id="answer">

    </div>
    <div id="image">
        <?php 
            if($data[0]['type']==='msg'){
                echo $data[0]['answer'];
            }
            else{
                echo '<img src="http://localhost/System_of_electronic_document_circulation/'.$data[0]['answer'].'.png">';
            }
        ?>
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
            $('#sign').attr("disabled", "disabled");
            event.preventDefault();
            var img = $('#signature').prop('files')[0];
            var docName = '<?php echo $_GET['d'];?>';
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