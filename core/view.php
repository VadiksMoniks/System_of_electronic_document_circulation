<?php

    class View{

        function generate($template_view, $data=null)
        {
           
            include 'views/templates/'.$template_view;
            
        }

    }

?>