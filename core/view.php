<?php

    namespace Core; 

    class View{

        function generate($template_view, $view=null, $data=null)
        {
           
            include 'views/templates/'.$template_view;
            
        }

    }

?>