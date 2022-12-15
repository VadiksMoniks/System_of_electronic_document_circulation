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
        <link href="http://localhost/System_of_electronic_document_circulation/styles/newsANDupdates.css" rel="stylesheet" type="text/css" />
        </head>
    
<body>
<p id="header"><?php echo $$lang['blogHeader'];?></p>
 <div id="blog">

 </div>
 <div id="wishess">
                <p class="h">Your wishess</p>
                <form >         
                    <textarea id="wishes_text"></textarea>
                    <button id="wishes">Send</button>
                </form>
                <p id="answer1"></p>
            </div>
            <div id="bugReport">
                <p class="h">Report a bug</p>
                <form >
                    <textarea placeholder="description of a bug"  id="bug_text"></textarea>
                    <button id="bug_report">Send</button>
                </form>
                <p id="answer2"></p>
            </div>
</body>
</html>
<script>
    $(document).ready(function(){
        
           

            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/newsANDupdates/readBlog',
                data:{},

                success:function(data){
                    $('#blog').html(data);
                    console.log(data);
                }
            });

        //add wish
        $(document).on('click', '#wishes', function(event){
            event.preventDefault();
            
            var wish = $('#wishes_text').val();
            var user = '<?php echo $_COOKIE['username']; ?>';
            console.log(wish);
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/newsANDupdates/add_wish',
                data:{wish:wish,user:user},

                success:function(data){
                    $('#wishes_text').val('');
                    $('#answer1').html(data);
                }
            });
        });
        //report a bug
        $(document).on('click', '#bug_report', function(event){
            event.preventDefault();
            
            var bug = $('#bug_text').val();
            var user = '<?php echo $_COOKIE['username']; ?>';
            console.log(bug);
            $.ajax({
                type:'POST',
                url:'http://localhost/System_of_electronic_document_circulation/index.php/newsANDupdates/add_report',
                data:{bug:bug, user:user},

                success:function(data){
                    $('#bug_text').val('');
                    $('#answer2').html(data);
                    
                }
            });
        });

        });
</script>