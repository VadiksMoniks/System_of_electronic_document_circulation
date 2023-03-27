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
       <div id="notHandwritten">
        <p id="h1"><?php echo $$lang['list.docs'];?></p>
            <ul id="doclist">
                <li><?php echo $$lang['doc2.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=voluntary_deduction"><?php echo $$lang['create.docs'];?></a></li>
                <li>Повторний курс навчання<ul>
                    <li><?php echo $$lang['doc3.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=returning_to_study_on_a_repeat_course"><?php echo $$lang['create.docs'];?></a></li>
                    <li><?php echo $$lang['doc4.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=providing_a_repeat_course"><?php echo $$lang['create.docs'];?></a></li>
                </ul></li>
            <li>Академічна відпустка<ul>
                <li><?php echo $$lang['doc5.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=granting_academic_leave"><?php echo $$lang['create.docs'];?></a></li>
                <li><?php echo $$lang['doc6.docs'];?> <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=extension_of_academic_leave"><?php echo $$lang['create.docs'];?></a></li>
                </ul></li>
                <li>Переведення здобувачів вищої освіти</li>
                <li>Поновлення до складу студентів (після відрахування)  <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=renewal_to_higher_education_institution"><?php echo $$lang['create.docs'];?></a></li>
                <li>Зміна джерела фінансування  <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=transfer_from_the_budget_to_the_contract"><?php echo $$lang['create.docs'];?></a></li>
                <li>Зміна особистих данних(прізвища) <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/formating?name=change_of_personal_data_(surname)"><?php echo $$lang['create.docs'];?></a></li>
            </ul>
       </div>
       <div id="Handwritten">
        <p id="h2"><?php echo $$lang['HWList.docs'];?></p>
            <ul>                   
                <li><?php echo $$lang['doc1'];?><ul>
                    <li>Надання соціальної стипендії <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=accural_of_social_scholarship"><?php echo $$lang['example.docs'];?></a></li>
                    <li>Продовження виплати соціальної стипендії <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=continuation_of_the_payment_of_the_social_scholarship"><?php echo $$lang['example.docs'];?></a></li>
                </ul></li>             
                <li>Нарахування додаткових балів до стипендіального рейтингу <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=voluntary_deduction"><?php echo $$lang['example.docs'];?></a></li>
                <li>Зняття копії документів, що знаходяться у відділі кадрів <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=removal_of_copies_of_documents_located_in_the_personnel_department"><?php echo $$lang['example.docs'];?></a></li>
                <li>Видача оригінала ЗНО <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=issuance_of_the_original_ZNO"><?php echo $$lang['example.docs'];?></a></li>
                <li>Поліпшення оцінки <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=improvement_of_assessment"><?php echo $$lang['example.docs'];?></a></li>
                <li>Перезарахування оцінок <a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/handwritten?name=re_enrollment_of_grades"><?php echo $$lang['example.docs'];?></a></li>
            </ul>
       </div>
    </div>

</body>
</html>
<script>
</script>