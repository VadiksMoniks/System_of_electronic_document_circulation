<?php
if(!isset($_SESSION['user'])){
  header("Location:http://localhost/System_of_electronic_document_circulation/index.php");
}
?>
<div id="answer">
  <?php 
      for($i=0; $i<count($data); $i++){
        echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/account/download?name='.basename($data[$i], '.pdf').'">'.basename($data[$i]).'</a><br/>';
      }
      
  ?>
</div>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <script>
    $(document).ready(function(){
       /* var user = '<?php echo $_SESSION['user'];?>';

        $.ajax({
            type:'POST',
            url:'http://localhost/System_of_electronic_document_circulation/index.php/account/docList',
            data:{user:user},
            success:function(data){
                $('#answer').html(data);
            }
        });*/
    });
    
    //console.log(user);

  </script>