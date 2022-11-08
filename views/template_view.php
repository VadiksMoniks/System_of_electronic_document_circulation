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
    </head>
    
    <body>
        <p id="result"></p>
        <!--<p>template view</p>-->
        <ul>
            <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/main"><?php echo $$lang['main.menu'];?></a></li>
            <li><a href="http://localhost/System_of_electronic_document_circulation/index.php/documents/document_list"><?php echo $$lang['documents.menu'];?></a></li>
            <li><a href=""><?php echo $$lang['nANDu.menu'];?></a></li>
        <?php
            if(!empty($_COOKIE['username'])){
                echo '<li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/account">'.$$lang['account.menu'].'</a></li>';
            }
            else{
                echo '<li><a href="http://localhost/System_of_electronic_document_circulation/index.php/account/registre">'.$$lang['reg.menu'].'</a></li>';
            }
        ?>
            <li>
                <ul>
                    <li><button class="lang" id="ua">UA</button></li>
                    <li><button class="lang" id="en">EN</button></li>
                </ul>
            </li>
    </ul>
    </body>
<script>
    $(document).ready(function(){
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
