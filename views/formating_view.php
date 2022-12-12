<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <!DOCTYPE html>
<html>
    <head>
        <tittle></tittle>
        <style>
            #border{
                margin-top:-200px;
              margin-left:30%;  
              width:800px;
                border: 5px solid;
                border-color: #000;
            }
            #list{
                width: 177px;
                padding-right: 50px;
            }
        </style>
        </head>
    
<body>
<form enctype="multipart/form-data">
    <input type="text" placeholder='initials' id="initials"><br/>
    <input type="text" placeholder='group' id="group"><br/>
    <input type="text" placeholder="recipient" id="recipient"><br/>
    <div id="list"></div>
    <textarea  maxlength="250" id="text"style="height: 100px; width:150px"></textarea></br>
    <input type="file" id="signature"><br/>
    <button id="generate">generate</button>
</form>
<p id="answer"></p>

<?php
   // header('Content-type: text/html; charset=utf-8');
    //header('Content-Encoding: gzip');
    //var_dump($_GET);
   // header('Content-type: text/html; charset=utf-8');


    $example = imagecreatefrompng('http://localhost/System_of_electronic_document_circulation/document_examples/canvas.png');
    $file = 'http://localhost/System_of_electronic_document_circulation/document_examples/'.$_GET['name'].'.txt';
   // $handle = fopen($filename, "r");
    $filetext = mb_convert_encoding(file_get_contents($file), 'UTF-8');
    $textarr = explode(';',$filetext);
    //fclose($handle);
    imagettftext($example, 15, 0, 450, 100, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[0]);
    imagettftext($example, 15, 0, 450, 140, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[1]);
    imagettftext($example, 15, 0, 350, 180, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[2]);
    imagettftext($example, 15, 0, 450, 240, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[3]);
    imagettftext($example, 15, 0, 380, 350, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[4]);
    imagettftext($example, 15, 0, 150, 400, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[5]);
    imagettftext($example, 15, 0, 150, 450, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[6]);
    imagettftext($example, 15, 0, 200, 850, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[7]);
    imagettftext($example, 15, 0, 300, 800, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[8]);
    imagettftext($example, 15, 0, 650, 850, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[9]);
    imagettftext($example, 15, 0, 550, 1100, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[10]);
    

    imagepng($example, 'ticket.png');
    imagedestroy($example);

            echo '<div id="border">';
            echo '<img src="http://localhost/System_of_electronic_document_circulation/ticket.png">';
            echo '</div>';
?>
</body>
</html>
<!--<button id="exampleDwn">Download example</button> -->
<script>
    $(document).ready(function(){
        $(document).on('click', '#generate', function(event){
            event.preventDefault();
            if('<?php if(isset($_COOKIE['username'])){echo 'regisered';} else{echo 'unregistered';}?>' ==='unregistered'){
                $('#answer').html("You can't seend documents while You unregistered on this site");
            }
            else{
                var name = "<?php echo  $_GET['name'];?>";
                var initials = $('#initials').val();
                var group = $('#group').val();
                var recipient = $('#recipient').val();
                var text = $('#text').val();

                var img = $('#signature').prop('files')[0];
                var data = new FormData;
                data.append('file', img);
                data.append('name', name);
                data.append('initials', initials);
                data.append('group', group);
                data.append('recipient', recipient);
                data.append('text', text);

                console.log(name);
                $.ajax({
                    type:'POST',
                    url:'http://localhost/System_of_electronic_document_circulation/index.php/documents/generate',
                    data:data,
                    contentType : false,
                    processData: false,

                    success:function(data){
                        //$('#dwnld').attr('href', 'http://localhost/System_of_electronic_document_circulation/index.php/documents/download?name='+data); 
                        $('#answer').html(data);
                    }
                });
            }

        });

        $('#recipient').keyup(function(){

            var recipientName = $(this).val();
                if(recipientName != ''){
                    $.ajax({
                        url:'http://localhost/System_of_electronic_document_circulation/index.php/documents/getList',
                        method:'POST',
                        data:{recipientName:recipientName},
                        success:function(data){
                            $('#list').fadeIn();
                            $('#list').attr('visibility', 'visible');
                            $('#list').attr('opacity', '1');
                            $('#list').html(data);
                        }
                    });
                }
                else{
                    $('#list').fadeOut();
                }

        });


        /*$(document).on('click', '#exampleDwn', function(event){
            var name = "<?php //echo  $_GET['name'];?>";
            $.ajax({
                    type:'POST',
                    url:'http://localhost/System_of_electronic_document_circulation/index.php/documents/downloadExample',
                    data:{name:name},

                    success:function(){
                        //$('#dwnld').attr('href', 'http://localhost/System_of_electronic_document_circulation/index.php/documents/download?name='+data); 
                        
                    }
                });
        });*/

    });
</script>