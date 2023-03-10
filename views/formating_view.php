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
                margin-top:-200px;
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
<form enctype="multipart/form-data">
    <label>course number <select id="course">
        <option class="variant">1</option>
        <option class="variant">2</option>
        <option class="variant">3</option>
        <option class="variant">4</option>
        <option class="variant">5</option>
        <option class="variant">6</option>
    </select></label></br>
    <input type="text" placeholder='group' id="group"><br/>
    <input type="text" placeholder='speciality' id="speciality"><br/>
    <select id="studyingForm">
        <option class="variant">daytime</option>
        <option class="variant">extramural</option>
    </select></br>
    <input type="text" placeholder='initials' id="initials"><br/>
   <!-- <input type="text" placeholder="recipient" id="recipient"><br/> -->
   <!-- <div id="list"></div> -->
    <textarea  maxlength="250" id="text"style="height: 100px; width:150px"></textarea></br>
    <input type="file" id="signature"><br/>
    <?php
        if(!isset($_SESSION['user'])){
            echo "You can't make documents before you log in or sign in";
        }
        else{
            echo '<button id="generate">generate</button>';
        }
    ?>
</form>

<p id="answer"></p>
<div id="document"><?php echo $data; ?></div>
</body>
</html>
<!--<button id="exampleDwn">Download example</button> -->
<script>
    $(document).ready(function(){

        $(document).on('click', '#generate', function(event){
            event.preventDefault();
                var name = "<?php echo  $_GET['name'];?>";
                var course = $('#course').val();
                var studyingForm = $('#studyingForm').val();
                var group = $('#group').val();
                var speciality = $('#speciality').val();
                var initials = $('#initials').val();
               // var recipient = $('#recipient').val();
                var text = $('#text').val();
                var mail = '<?php echo $_SESSION['user'];?>';

                var img = $('#signature').prop('files')[0];
                var data = new FormData;
                data.append('file', img);
                data.append('name', name);
                data.append('mail',mail);
                data.append('course', course);
                data.append('studyingForm', studyingForm);
                data.append('group', group);
                data.append('speciality', speciality);
                data.append('initials', initials);
              //  data.append('recipient', recipient);
                data.append('text', text);

                console.log(course);
                console.log(studyingForm);
                $.ajax({
                    type:'POST',
                    url:'http://localhost/System_of_electronic_document_circulation/index.php/documents/generate',
                    data:data,
                    contentType : false,
                    processData: false,

                    success:function(data){
                        //$('#dwnld').attr('href', 'http://localhost/System_of_electronic_document_circulation/index.php/documents/download?name='+data); 
                        data = JSON.parse(data);
                        $('#answer').html(data.answer);
                    }
                });

        });

    /*    $('#recipient').keyup(function(){

            var recipientName = $(this).val();
                if(recipientName != ''){
                    $.ajax({
                        url:'http://localhost/System_of_electronic_document_circulation/index.php/documents/getList',
                        method:'POST',
                        data:{recipientName:recipientName},
                        success:function(data){
                            $('#list').fadeIn();
                            $('#list').html(data);
                        }
                    });
                }
                else{
                    $('#list').fadeOut();
                }

        });*/

      /*  $(document).on('click', '.variants', function(){
            $('#recipient').val($(this).attr('name'));
            //$('#list').attr('display', 'none');
            $('#list').css("display", "none");
        });*/

    });
</script>