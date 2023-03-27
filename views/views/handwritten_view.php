<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <!DOCTYPE html>
<html>
    <head>
        <tittle></tittle>
        <style>
            #document{
                margin-top:50px;
              margin-left:30%;  
              width: 600px;
              height: 800px;
                border: 5px solid;
                border-color: #000;
            }
            #list{
                background-color: #d3d3d3;
                width: 177px;
                z-index: 99;
                position: absolute;
            }
            img { width: auto; height: 100%; }
        </style>
    </head>
<body>
<h1>Узнать, кто должен подписывать</h1>
<form enctype="multipart/form-data">
    <input type="file" id="documentFile"><br/>
    <?php
        if(!isset($_SESSION['user'])){
            echo "You can't make documents before you log in or sign in";
        }
        else{
            echo '<button id="send">generate</button>';
        }
    ?>
</form>
<p id="answer"></p>
<div id="document">
    <?php echo $data; ?>
</div>
</body>
</html>
<script>
        $(document).ready(function(){

            $(document).on('click', '#send', function(event){
                event.preventDefault();
                var name = "<?php echo  $_GET['name'];?>";
                var sender = '<?php echo $_SESSION['user'];?>';
                var img = $('#documentFile').prop('files')[0];
                var data = new FormData;
                data.append('file', img);
                data.append('name', name);
                data.append('sender',sender);

                $.ajax({
                    type:'POST',
                    url:'http://localhost/System_of_electronic_document_circulation/index.php/documents/makeHandwritten',
                    data:data,
                    contentType : false,
                    processData: false,

                    success:function(data){
                        //$('#dwnld').attr('href', 'http://localhost/System_of_electronic_document_circulation/index.php/documents/download?name='+data); 
                       // data = JSON.parse(data);
                        $('#answer').html(data);
                    }
                });
            });
        });
</script>