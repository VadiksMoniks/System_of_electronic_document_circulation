<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<form enctype="multipart/form-data">
    <input type="text" placeholder='initials' id="initials"><br/>
    <input type="text" placeholder='group' id="group"><br/>
    <input type="text" placeholder="recipient" id="recipient"><br/>
    <input type="file" id="signature"><br/>
    <button id="generate">generate</button>
</form>
<p id="answer"></p>

<?php
   // header('Content-type: text/html; charset=utf-8');
    //header('Content-Encoding: gzip');
    //var_dump($_GET);
   // header('Content-type: text/html; charset=utf-8');


    /*$example = imagecreatefrompng('http://localhost/System_of_electronic_document_circulation/document_examples/canvas.png');
    $file = 'http://localhost/System_of_electronic_document_circulation/document_examples/'.$_GET['name'].'.txt';
   // $handle = fopen($filename, "r");
    $filetext = mb_convert_encoding(file_get_contents($file), 'UTF-8');
    $textarr = explode(';',$filetext);
    //fclose($handle);
    imagettftext($example, 15, 0, 250, 100, imagecolorallocate($example,0,0,0), 'Lato-Black.ttf', $textarr[0]);
    imagettftext($example, 15, 0, 50, 140, imagecolorallocate($example,0,0,0), 'Lato-Black.ttf', $textarr[1]);
    imagettftext($example, 15, 0, 50, 180, imagecolorallocate($example,0,0,0), 'Lato-Black.ttf', $textarr[2]);
             imagepng($example, 'ticket.png');
             imagedestroy($example);*/
            echo '<img src="http://localhost/System_of_electronic_document_circulation/ticket.png">';
?>

<script>
    $(document).ready(function(){
        $(document).on('click', '#generate', function(event){
            event.preventDefault();

            var name = "<?php echo  $_GET['name'];?>";
            var initials = $('#initials').val();
            var group = $('#group').val();
            var recipient = $('#recipient').val();

            var img = $('#signature').prop('files')[0];
            var data = new FormData;
            data.append('file', img);
            data.append('name', name);
            data.append('initials', initials);
            data.append('group', group);
            data.append('recipient', recipient);

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
        });
    });
</script>