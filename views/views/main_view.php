<style>
    #slider{
        margin-top: -80px;
        margin: 10px auto;
        overflow: hidden;
        max-width: 44%;
        height: 450px;
    }
    #slide{width: auto; height: 100%;}

    #info{

        display: flex;
    }
    #navigator{
        width: 15%;
    }

    #text{
        width: 80%;
    }

    .screen{
        margin-top: -80px;
        margin: 10px auto;
        overflow: hidden;
        max-width: 50%;
        height: 500px;
    }

    img{
        width: auto; height: 100%; 
    }

</style>

<div id="slider">

        <img src="../styles/khpi2.jpg" id="slide" id="slide">

</div>
<div id="info">
    <div id="navigator">
        <ul>
            <li><a href="#part1">Про цей сайт</a></li>
            <li><a href="#part2">Які документи тут є</a></li>
            <li><a href="#part3">Як мені створити документ?</a></li>
            <li><a href="#part4">Як довго буде доступний документ?</a></li>
            <li><a href="#part5">Частина 5</a></li>
        </ul>
    </div>
    <div id="text">
        <h2 id="part1">Про цей сайт</h2></br>
            Данний ресурс використовується університетом НТУ 'ХПІ' та призначений для створення, зберігання та обміну внутрішніми документами, що діють на території НТУ 'ХПІ'
            Якщо ви студент НТУ 'ХПІ' і вам необхідно підписати якусь заяву - ви можете зробити це ДИСТАНЦІЙНО, не виходячи з дому і не витрачаючи гроші на друк бланків абож
            час на те, аби потрапити в дирекцію чи ще деінде 
    </br>
    </br>
    </br>
    </br>
    </br>
    <h2 id="part2">Які документи тут є</h2></br>
        На сайті є всі документи, що використовуються НТУ 'ХПІ'
    </br>        
        <div class="screen">
            <img src="../styles/s1.png">
        </div>
    </br>
    <h2 id="part3">Як мені створити документ?</h2></br>
        Процедура дуже проста! Вам необхідно зараєструватися на сайті, використавши вашу корпоративну пошту, далі перейти у розділ 'Документи', обрати потрібний, 
        заповнити усі необхідні данні і просто зачекати, доки його підпишуть. Як тільки це відбудеться, ви отримаєте повідомлення на пошту
         і зможете завантажити цей документ зі свого акаунту у розділі 'Завантажити'
        </br>
        <div class="screen">
            <img src="../styles/s2.png">
        </div>
    </br>
    <h2 id="part4">Як довго буде доступний документ?</h2></br>
        Усі ваші документи зберігаються у базі данних НТУ 'ХПІ' та доступні для завантаження у будь-який час з вашого акаунту
    </br>
    <div class="screen">
            <img src="../styles/s3.png">
        </div>
    </br>
    </br>
    <h2 id="part5">h5</h2></br>
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
    </br>
    </div>
</div>
<script>
    let links = ['../styles/khpi2.jpg','../styles/IMG_20151006_182429-Pano.jpg', '../styles/ttr.jpg', '../styles/Picture-1.jpg', '../styles/izgotovlenie-pechati-dlya-ip-v-saratove.jpg'];
    let count =0;
    setInterval(function(){
        count ++;
        if(count>=links.length){
            count = 0;
        }
        document.getElementById("slide").src=links[count];
    }, 3000);
</script>