<?php
?>
<!--<div>
    <ul>
        <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/adminPanel">Main</a></li>
        <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/post">Post an article</a></li>
        <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/articles_list">articles list</a></li>
        <li></li>
    </ul>
</div>-->

<?php

    if(!isset($view)){
        if(isset($_SERVER['PATH_INFO'])){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/admin_views/'.trim($_SERVER['PATH_INFO'], '/').'_view.php';
        }
        else{
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/views/main_view.php';
        }
    }
    else{
        include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/admin_views/'.$view.'_view.php';
    }

?>
