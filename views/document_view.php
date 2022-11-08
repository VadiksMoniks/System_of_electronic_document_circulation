<?php
    include 'languages.php';
    $lang=$_COOKIE['lang'];
    //echo '';
        /*<li><button class="example" id="2">Переглянути приклад</button> Відрахування за власним бажанням <button>Завантажити</button></li>
    <li><button class="example" id="3">Переглянути приклад</button> Поновлення до складу студентів (після відрахування) <button>Завантажити</button></li>
    <li>Академічна відпустка<ul>
        <li><button class="example" id="4">Переглянути приклад</button> Надання академічної відпустки <button>Завантажити</button></li>
        <li><button class="example" id="5">Переглянути приклад</button> Продовження та повернення з академічної відпустки <button>Завантажити</button></li>
    </ul></li>
    
    <li>Переведення здобувачів вищої освіти<ul>
        <li><button class="example" id="6">Переглянути приклад</button> Переведення до/з інших закладів вищої освіти <button>Завантажити</button></li>
        <li><button class="example" id="7">Переглянути приклад</button> Переведення в межах універсиету <button>Завантажити</button></li>
    </ul></li>
    <li>Інші зразки заяв <ul>
            <li><button class="example" id="8">Переглянути приклад</button> Зразок заяви на зміну особистих даних (прізвища) <button>Завантажити</button></li>
            <li><button class="example" id="9">Переглянути приклад</button> Зразок заяви на видачу оригінала ЗНО <button>Завантажити</button></li>
            <li><button class="example" id="10">Переглянути приклад</button> Зразок заяви на поліпшення оцінки <button>Завантажити</button></li>
            <li><button class="example" id="11">Переглянути приклад</button> Зразок заяви на перезарахування оцінок <button>Завантажити</button></li>
        </ul>
    </li>*/

?>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<p><?php echo $$lang['list.docs'];?></p>
<ul>
    <li><button class="example" id="1"><?php echo $$lang['example.doc'];?></button><?php echo $$lang['doc1.docs'];?><a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=a"><?php echo $$lang['create.docs'];?></a></li>

   
</ul>
<p id="example_show"></p>
<script>
    $(document).ready(function(){
        $(document).on('click','.example', function(){
            var example = $(this).attr('id');
            console.log(example);

            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/documents/getExample',
                data:{example:example},
                
                success:function(data){
                        $('#example_show').fadeIn();
                        $('#example_show').html(data);
                        //console.log($('#answer').val());
                        //if(data == "OK"){
                         //   location.reload();
                        //}
                }
            });
        });
    });
        
</script>