<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <!DOCTYPE html>
<html>
    <head>
        <tittle></tittle>
        <style>
            #document{
                margin-top:50px;
              margin-left:30%;  
              width: 600px;
              height: 800px;
                border: 5px solid;
                border-color: #000;
            }
            #list{
                background-color: #d3d3d3;
                width: 177px;
                z-index: 99;
                position: absolute;
            }
            img { width: auto; height: 100%; }
        </style>
    </head>
<body>
<div id="document"><?php echo $data; ?></div>
</body>