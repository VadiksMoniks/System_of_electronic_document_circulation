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

</style>

<div id="slider">

        <img src="../styles/1172237.jpg" id="slide" id="slide">

</div>
<div id="info">
    <div id="navigator">
        <ul>
            <li><a href="#part1">Частина 1</a></li>
            <li><a href="#part2">Частина 2</a></li>
            <li><a href="#part3">Частина 3</a></li>
            <li><a href="#part4">Частина 4</a></li>
            <li><a href="#part5">Частина 5</a></li>
        </ul>
    </div>
    <div id="text">
        <p id="part1">Частина 1</p></br>
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
    </br>
    </br>
    </br>
    </br>
    </br>
    <p id="part2">Частина 2</p></br>
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
    </br>
    </br>
    <p id="part3">Частина 3</p></br>
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        </br>
    </br>
    <p id="part4">Частина 4</p></br>
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere voluptatem atque nobis ex. 
        Laborum eaque repudiandae velit aliquid, nesciunt voluptatem reprehenderit ex amet! Repellendus, esse. Nam facilis nulla est enim.
    </br></br>
    </br>
    <p id="part5">h5</p></br>
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