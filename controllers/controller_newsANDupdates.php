<?php

    class Controller_newsANDupdates extends Controller{

        function __construct()
        {
            $this->view = new View();
            //$this->model = new Model_Account();
        }

        function action_newsANDupdates(){
            $this->view->generate('newsANDupdates_view.php', 'template_view.php');
        }

        function action_readBlog(){
            $output='';
            $blogsList = scandir('E:/xampp/htdocs/System_of_electronic_document_circulation/Blogs/', SCANDIR_SORT_NONE);
           // var_dump($blogsList);
            for($i=2; $i<count($blogsList); $i++){
                $text = explode(';',file_get_contents('E:/xampp/htdocs/System_of_electronic_document_circulation/Blogs/'.$blogsList[$i]));
                for($j=0; $j<count($text); $j++){
                    if($j===0){
                        $output.='<p class="paragraph">';
                    }
                    else if($j===count($text)-1){
                        $output.=$text[$j].'</p></br>';
                    }
                    else{
                        $output.=$text[$j].'</br>';
                    }
                    
                }
                
            }
            echo $output;
        }

        
    }

?>