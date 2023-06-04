<?php

    if($_SESSION['admin']){
        echo '<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/logOut" id="out">log out</a>';
    }
    else{
        header('Location:http://localhost/System_of_electronic_document_circulation/index.php/admin/authorization');
    }

?>
<style>
    #table,td{
   border: 1px solid black;
}
</style>
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

    <select id="status">
        <option class="variant">unchecked</option>
        <option class="variant">unsigned</option>
    </select>

    <input type="text" id="name">

    <button id="search">search</button>
</div>
<div id="list">
    <table id="table">
    <?php
    //var_dump($data);
        for($i=0; $i<count($data['path']); $i++){
            echo '<tr>';
            echo '<td><a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='.$data['path'][$i].'">'.$data['path'][$i].'</a></td>'; 
            echo '<td><p>'.$data['status'][$i].'</p></td>'; 
            echo '<td><p>'.$data['sender'][$i].'</p></td>'; 
            echo '</tr>';
        }
    ?>

    </table>
 </div>

<script>
    $(document).ready(function(){

        //$(document).on('change', '#names', function(event){
            $(document).on('click', '#search', function(event){
            event.preventDefault();
            var type = $('#names').val();
            var status = $('#status').val();
            var name = $('#name').val();
            console.log(type);
          //  if(docName!="Select document name"){
                $.ajax({
                    type:'POST',
                    url:'http://localhost/System_of_electronic_document_circulation/index.php/admin/filter',
                    data:{type:type, status:status, name:name},
                        //contentType : false,
                        //processData: false,

                    success:function(data){
                            //$('#dwnld').attr('href', 'http://localhost/System_of_electronic_document_circulation/index.php/documents/download?name='+data);
                        $('#list').empty(); 
                        //$('#list').html(data);
                        data = JSON.parse(data);
                        $('#list').fadeIn();
                        $('#list').html('<table id="table">');
                        console.log(data.path.length);
                        for(let i=0; i<data.path.length; i++)
                        {
                             //$('#list').append('<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='+data.path[i]+'">'+data.path[i]+'</a></br>');
                             $('#list').append('<tr>');
                             $('#list').append('<td><a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='+data.path[i]+'">'+data.path[i]+'</a></td>'); 
                             $('#list').append('<td><p>'+data.status[i]+'</p></td>'); 
                             $('#list').append('<td><p>'+data.sender[i]+'</p></td>'); 
                             $('#list').append('</tr>');
                        }
                        $('#lisn').append('</table>');
                       
                    }
                });
        });
    
        // 
    });      
            
</script>

