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
                if($i===2){
                    $output.='<div class="blog" style="margin-bottom:50px;">'.file_get_contents('E:/xampp/htdocs/System_of_electronic_document_circulation/Blogs/'.$blogsList[$i]).'</br><p>Release update: 1 month</p></div>';
                }
                else{
                    $output.='<div class="blog" style="margin-bottom:50px;">'.file_get_contents('E:/xampp/htdocs/System_of_electronic_document_circulation/Blogs/'.$blogsList[$i]).'</br><p>Release update: TBA</p></div>';
                }
                
            }
            echo $output;
        }

        
    }

?>