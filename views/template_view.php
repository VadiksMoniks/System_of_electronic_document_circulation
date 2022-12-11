<?php
    include 'languages.php';
    if(empty($_COOKIE['lang'])){
        setcookie('lang', 'en',strtotime( '+30 days' ) ,'/');
    }
     $lang = $_COOKIE['lang'];
?>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<!DOCTYPE html>
<html>
    <head>
        <tittle></tittle>
        <style>
            body{
                margin: 0;
                overflow-x: hidden;
                height: 100%;
            }
            ul{
                list-style-type: none;
            }
            .list{
                width: 100%;
                margin-left: 15%;
                display: inline-flex;
            }
            .menuP{
                margin-left: 100px;
                font-size: 23px;
            }
            li{
                
            }

            a{
                font-size: 20px;
                
                text-decoration: none;
                color: #000;
            }
            a:hover{
                color: #F64C72;
            }

            #headerMenu{
                min-width: 100%;
                height: 90px;
                background-color: #A8D0E6;
                padding-top: 30px;
                margin: 0;
            }

            #langs li{
                margin-top: 5px;
                
            }
            .lang{
                width: 70px;
            }

            #logo{
                margin-top: -10px;
                margin-left: 100px;
                margin-right: 50px;
            }
            #acc:hover #outBlock{
                visibility: visible;

            }
            #langs #out{
                margin-top: 100px;
                font-size: 20px;
             }

            #langDiv{
                margin-top: -15px;
                width: 150px;
                margin-left: 50px;
                padding-left: 50px;
            }

            #content{
                min-height: 100%;
                padding: 50px;
            }

            #footer{
                margin-left: 0;
                margin-right: 0;
                width: 100%;
                height: 200px;
                background-color: #07575B;
                flex: 0 0 auto;
                padding: 30px;
                
            }
            #wishess{
                float: left;
            }
            #bugReport{
                
                float: left;
                margin-left:150px
            }
            .h{
                font-size: 20px;
                color: #fff;
            }

        </style>
    </head>
    
    <body>
        <p id="result"></p>
        <!--<p>template view</p>-->
        <div id="headerMenu">
            <ul class="list">
                <li ><a href="http://localhost/System_of_electronic_document_circulation/index.php/main" class="menuP"><?php echo $$lang['main.menu'];?></a></li>
                <li ><a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/document" class="menuP"><?php echo $$lang['documents.menu'];?></a></li>
                <li ><a href="https://web.kpi.kharkov.ua/infiz/uk/home/" class="menuP"><img src="http://localhost/System_of_electronic_document_circulation/img/logo.png" id="logo"></a></li>
                <li ><a href="http://localhost/System_of_electronic_document_circulation/index.php/newsANDupdates/newsANDupdates" class="menuP"><?php echo $$lang['nANDu.menu'];?></a></li>
                    <?php
                        if(!empty($_COOKIE['username'])){
                            echo '<li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/account" class="menuP">'.$$lang['account.menu'].'</a></li>';
                        }
                        else{
                            echo '<li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/registre" class="menuP" id="acc">'.$$lang['reg.menu'].'</a></li>';
                        }
                    ?>
                        
                <li>
                    <div id="langDiv">
                        <ul id="langs">
                            <li><button class="lang" id="ua">UA</button></li>
                            <li><button class="lang" id="en">EN</button></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div id="content">
        <?php

            if(!isset($_SERVER['PATH_INFO'])){
                include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/main_view.php';
            }
            else{
                if(file_exists('E:/xampp/htdocs/System_of_electronic_document_circulation/views/'.basename($_SERVER['PATH_INFO']).'_view.php')){
                    include 'E:/xampp/htdocs/System_of_electronic_document_circulation/views/'.basename($_SERVER['PATH_INFO']).'_view.php';
                }
                else{
                    echo '404';
                }
            }
        ?>
        </div>
        <div id="footer">
            <p>hello</p>
        </div>
    </body>
<script>
    $(document).ready(function(){


    //change language
        $(document).on('click', '.lang', function(event){
            event.preventDefault();
            
            var lang = $(this).attr('id');
            console.log(lang);
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/main/changeLang',
                data:{lang:lang},

                success:function(){
                    location.reload();
                }
            });
        });
    
    });
</script>
</html>
