<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <form>
    <input type="password" placeholder="old password" id="old">
    <input type="password" placeholder="new password" id="new">
    <p id="answer"></p>
    <button id="send">send</button>
  </form>

  <script>
    $(document).ready(function(){
        $(document).on('click', '#send', function(event){
            event.preventDefault();

            var oldPass = $('#old').val();
            var newPass = $('#new').val();
            var user = '<?php echo $_SESSION['user'];?>';

            $.ajax({
                    type:'POST',
                    url:'http://localhost/System_of_electronic_document_circulation/index.php/account/change_password',
                    data:{oldPass:oldPass, newPass:newPass, user:user},

                    success:function(data){
                        $('#answer').html(data);
                    }
                });
        });
    });
</script>