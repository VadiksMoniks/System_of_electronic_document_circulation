<?php

    if($_SESSION['admin']){
        echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/logOut" id="out">log out</a>';
    }
    else{
        header('Location:http://localhost/System_of_electronic_document_circulation/index.php/admin/authorization');
    }

?>

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<p>hello</p>
<div id="filters">
    <select id="names">
        <option class="variant">Select document name</option>
        <option class="variant">accural of social scholarship</option>
        <option class="variant">voluntary deduction</option>
        <option class="variant">returning to study on a repeat course</option>
        <option class="variant">providing a repeat course</option>
        <option class="variant">granting academic leave</option>
        <option class="variant">change of personal data (surname)</option>
        <option class="variant">continuation of the payment of the social scholarship</option>
        <option class="variant">extension of academic leave</option>
        <option class="variant">improvement of assessment</option>
        <option class="variant">issuance of the original ZNO</option>
        <option class="variant">re enrollment of grades</option>
        <option class="variant">removal of copies of documents located in the personnel department</option>
        <option class="variant">renewal to higher education institution</option>
        <option class="variant">transfer from the budget to the contract</option>
    </select>
</div>
<div id="list">
    <?php
    //var_dump($data);
        for($i=0; $i<count($data); $i++){
            echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='.$data[$i].'">'.$data[$i].'</a></br>'; 
        }
    ?>
 </div>

<script>
    $(document).ready(function(){
        
      /*      $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/admin/documentsList',
                data:{},

                success:function(data){
                    $('#list').fadeIn();
                    $('#list').html(data);
                }
        });*/

        $(document).on('change', '#names', function(event){
            event.preventDefault();
            var docName = $(this).val();
            console.log(docName);
          //  if(docName!="Select document name"){
                $.ajax({
                    type:'POST',
                    url:'http://localhost/System_of_electronic_document_circulation/index.php/admin/byDocName',
                    data:{docName:docName},
                        //contentType : false,
                        //processData: false,

                    success:function(data){
                            //$('#dwnld').attr('href', 'http://localhost/System_of_electronic_document_circulation/index.php/documents/download?name='+data);
                        $('#list').empty(); 
                        data = JSON.parse(data);
                        $('#list').fadeIn();
                        for(let i=0; i<data.length; i++)
                        {
                             $('#list').append('<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='+data[i]+'">'+data[i]+'</a></br>');
                        }
                       
                    }
                });
           // }
          /*else{
                $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/admin/adminPanel',
                data:{},

                success:function(data){
                    $('#list').fadeIn();
                    $('#list').html(data);
                }
        });
            }*/
        });
    
        // 
    });      
            
</script>

