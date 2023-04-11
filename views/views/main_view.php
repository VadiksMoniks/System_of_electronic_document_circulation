<style>
    #slider{
        border: 2px solid #000;
        margin: 20px auto;
        overflow: hidden;
        max-width: 80%;
        height: 500px;
    }
</style>
<p>main page</p>
<p>добавить в таблицу пользователей поле 'send notification' и сделать отправку сообщения на корпорат почту о том что можно скачать документ если в этом поле стоит true</p>
<div id="slider">

        <img src="../styles/1172237.jpg" id="slide">

</div>
<script>
    let links = ['../styles/1172237.jpg','../styles/1291310.png', '../styles/chainsaw-man-anime-himeno-voice-actor.jpg', '../styles/emerald-anime-girls-anime-himeno-chainsaw-man-chainsaw-man-hd-wallpaper-preview.jpg', '../styles/Himeno-Chainsaw-Man.jpeg'];
    let count =0;
    setInterval(function(){
        count ++;
        if(count>=links.length){
            count = 0;
        }
        document.getElementById("slide").src=links[count];
    }, 3000);
</script>