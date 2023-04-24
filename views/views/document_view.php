<?php
    include 'languages.php';
    $lang=$_COOKIE['lang'];
?>
<!DOCTYPE html>
<html>
    <head>
        <tittle></tittle>
        <link href="http://localhost/System_of_electronic_document_circulation/styles/docs_list.css" rel="stylesheet" type="text/css" />
    </head>
    
    <body>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<div id="docs">
 <div id="docs">
    <div id="categories">
        <p><?php echo $$lang['list.docs'];?></p>
        <ul class="category">
            <a href="#" class="link"><li><?php echo $$lang['doc1.docs'];?></li></a>
            <a href="#" class="link"><li><?php echo $$lang['doc1.headers'];?></li></a>
            <a href="#" class="link"><li><?php echo $$lang['doc2.headers'];?></li></a>
            <a href="#" class="link"><li><?php echo $$lang['doc6.docs'];?></li></a>
            <a href="#" class="link"><li><?php echo $$lang['doc7.docs'];?></li></a>
            <a href="#" class="link"><li><?php echo $$lang['doc8.docs'];?></li></a>
        </ul></br>
        <p><?php echo $$lang['HWList.docs'];?></p>
        <ul class="category">
        <a href="#" class="link"><li><?php echo $$lang['doc3.headers'];?></li></a>
        <a href="#" class="link"><li><?php echo $$lang['doc11.docs'];?></li></a>
        <a href="#" class="link"><li><?php echo $$lang['doc12.docs'];?></li></a>
        <a href="#" class="link"><li><?php echo $$lang['doc13.docs'];?></li></a>
        <a href="#" class="link"><li><?php echo $$lang['doc14.docs'];?></li></a>
        <a href="#" class="link"><li><?php echo $$lang['doc15.docs'];?></li></a>
        </ul></br>
    </div>
    <div id="examples">
        <p id="label">Chose type of document</p>
    </div>
</div> 
</div>
 <!--  <div id="notHandwritten">
        <p id="h1"><?php echo $$lang['list.docs'];?></p>
            <ul id="doclist">
                <li class="doc"><?php echo $$lang['doc1.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=voluntary_deduction"><?php echo $$lang['create.docs'];?></a></li>
                <li class="doc"><?php echo $$lang['doc1.headers'];?><ul>
                    <li class="doc"><?php echo $$lang['doc2.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=returning_to_study_on_a_repeat_course"><?php echo $$lang['create.docs'];?></a></li>
                    <li class="doc"><?php echo $$lang['doc3.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=providing_a_repeat_course"><?php echo $$lang['create.docs'];?></a></li>
                </ul></li>
            <li class="doc"><?php echo $$lang['doc2.headers'];?><ul>
                <li class="doc"><?php echo $$lang['doc4.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=granting_academic_leave"><?php echo $$lang['create.docs'];?></a></li>
                <li class="doc"><?php echo $$lang['doc5.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=extension_of_academic_leave"><?php echo $$lang['create.docs'];?></a></li>
                </ul></li>
                <li class="doc">Переведення здобувачів вищої освіти</li>
                <li class="doc"><?php echo $$lang['doc6.docs'];?>  <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=renewal_to_higher_education_institution"><?php echo $$lang['create.docs'];?></a></li>
                <li class="doc"><?php echo $$lang['doc7.docs'];?>  <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=transfer_from_the_budget_to_the_contract"><?php echo $$lang['create.docs'];?></a></li>
                <li class="doc"><?php echo $$lang['doc8.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=change_of_personal_data_(surname)"><?php echo $$lang['create.docs'];?></a></li>
            </ul>
       </div>
       <div id="Handwritten">
        <p id="h2"><?php echo $$lang['HWList.docs'];?></p>
            <ul>                   
                <li><?php echo $$lang['doc3.headers'];?><ul>
                    <li class="doc"><?php echo $$lang['doc9.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=accural_of_social_scholarship"><?php echo $$lang['example.docs'];?></a></li>
                    <li class="doc"><?php echo $$lang['doc10.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=continuation_of_the_payment_of_the_social_scholarship"><?php echo $$lang['example.docs'];?></a></li>
                </ul></li>             
                <li class="doc"><?php echo $$lang['doc11.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=voluntary_deduction"><?php echo $$lang['example.docs'];?></a></li>
                <li class="doc"><?php echo $$lang['doc12.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=removal_of_copies_of_documents_located_in_the_personnel_department"><?php echo $$lang['example.docs'];?></a></li>
                <li class="doc"><?php echo $$lang['doc13.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=issuance_of_the_original_ZNO"><?php echo $$lang['example.docs'];?></a></li>
                <li class="doc"><?php echo $$lang['doc14.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=improvement_of_assessment"><?php echo $$lang['example.docs'];?></a></li>
                <li class="doc"><?php echo $$lang['doc15.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=re_enrollment_of_grades"><?php echo $$lang['example.docs'];?></a></li>
            </ul>
       </div>
    -->

</body>
</html>
<script>
    $(document).ready(function(){
        $(document).on('click', '.link', function(event){
            event.preventDefault();
            let name = $(this).text();
            //console.log(name);

            $.ajax({
                    type:'POST',
                    url:'http://localhost/System_of_electronic_document_circulation/index.php/documents/getDocuments',
                    data:{name:name},

                    success:function(data){
                        $('#label').attr('visibility','hiden');
                        $('#label').attr('display','none');
                        //$('#dwnld').attr('href', 'http://localhost/System_of_electronic_document_circulation/index.php/documents/download?name='+data); 
                        data = JSON.parse(data);
                        let names = data.answer.split('/');
                        let links = data.links.split('/');
                        for(i=0; i<names.length; i++){
                            if(i==0){
                                $('#examples').html(names[i]+'<a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/'+links[i]+'"> '+'<?php echo $$lang['create.docs'];?>'+'</a></br>');
                            }
                            else{
                                $('#examples').append(names[i]+'<a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/'+links[i]+'"> '+'<?php echo $$lang['create.docs'];?>'+'</a></br>');
                            }
                        }
                        //$('#examples').html(names[0]+'</br>');
                        //$('#examples').html(names);
                        //$('#examples').html(data.links);
                        //$('#examples').html('<p>'+data.answer+'</p>');
                        //let arr = data.answer.split('/');
                        //for(let i=0; i<arr.length; i++){
                        //    $('#examples').html('<p>'+arr[i].toLowerCase().replaceAll(' ','_')+'</p><a href=""></a>');
                       // }
                       // console.log(arr.length);
                    }
                });
        });
    });
</script>