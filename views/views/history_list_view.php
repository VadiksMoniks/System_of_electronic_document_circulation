<div id="answer">
    <?php 
        //echo $data;
        if(gettype($data)==="array"){
            for($i=0; $i<count($data); $i++){
                if(isset($data[$i]["current"])){
                    echo '<p >'.$data[$i]['value'].'(Waiting to be signed by '.$data[$i]['current'].')</p></br>';
                }
                else{
                    echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/account/showDoc?name='.$data[$i]['value'].'">'.$data[$i]['value'].'('.$data[$i]['status'].')</a></br>';
                    if($data[$i]["status"]==="unchecked"){
                        echo  '<button value="'.$data[$i]["value"].'" class="btn">Delete record</button><br/>'; 
                    }
                }

               // else if($data[$i]["status"]==="checked"){
    
                //}
               // else if($data[$i]["status"]==="Deleted by admins"){
    
               // }
            }
        }
        else{
            echo $data;
        }
    ?>
</div>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <script>
    $(document).ready(function(){



   /*     var user = '<?php echo $_SESSION['user'];?>';

        $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/account/history',
                data:{user:user},
                success:function(data){
                    $('#answer').html(data);
                }
            });*/

        $(document).on('click', '.btn', function(event){
            event.preventDefault();
            var data = new FormData;
            var docName = $(this).val();
            var user = '<?php echo $_SESSION['user'];?>'
            data.append('docName', docName);
            data.append('user', user);
            console.log(user);
            
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