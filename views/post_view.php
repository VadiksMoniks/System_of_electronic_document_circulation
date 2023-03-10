<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<div>
    <form enctype="multipart/form-data">
        <label>Article name <input type="text" placeholder="article name" id="articleName"></br>
        <label>Article text  <input type="file" id="articleText"><br/>
        <label>Image  <input type="file" id="image"><br/>
        <button id="send">send</button>
    </form>
</div>
<div id="answer"></div>
<script>
    $(document).ready(function(){
        $(document).on('click', '#send', function(event){
            event.preventDefault();

            var data = new FormData;
            var name = $('#articleName').val();
            var text = $('#articleText').prop('files')[0];
            var image = $('#image').prop('files')[0];
            data.append('name', name);
            data.append('text', text);
            console.log(name);
            if(!image)
            {
                console.log('rgr');
            }
            
            else
            {
                data.append('image', image);
            }

            $.ajax({
                    type:'POST',
                    url:'http://localhost/System_of_electronic_document_circulation/index.php/admin/makePost',
                    data:data,
                    contentType : false,
                    processData: false,

                    success:function(data){
                        $('#answer').html(data);
                    }
                });
        });
    });

</script>