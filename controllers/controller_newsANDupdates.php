<?php

    class Controller_newsANDupdates extends Controller{

        public function __construct()
        {
            $this->view = new View();
            //$this->model = new Model_Account();
        }

        public function action_newsANDupdates(){
            $this->view->generate('template_view.php');
        }

        public function action_readBlog(){
            $output='';
            $blogsList = scandir('E:/xampp/htdocs/System_of_electronic_document_circulation/Blogs/', SCANDIR_SORT_NONE);
           // var_dump($blogsList);
            for($i=2; $i<count($blogsList); $i++){
                $text = explode(';',file_get_contents('E:/xampp/htdocs/System_of_electronic_document_circulation/Blogs/'.$blogsList[$i]));
                for($j=0; $j<count($text); $j++){
                    if($j===0){
                        $output.='<p class="paragraph">'.$text[$j];
                    }
                    else if($j===(count($text)-1)){
                        $output.=$text[$j].'</p></br>';
                    }
                    else{
                        $output.=$text[$j].'</br>';
                    }
                    
                }
                
            }
            echo $output;
        }

        public function action_add_wish(){
            $text= trim($_POST['wish']);
            $res='';
            if($text===''){
                echo   $res= 'plese fill thefield';
            }

            $filename = 'E:/xampp/htdocs/System_of_electronic_document_circulation/wishes.txt';

            $file = fopen($filename, 'a');

            fwrite($file, $text.'--'.$_COOKIE['username'].'#' . PHP_EOL);
            fclose($file);
            echo   $res='Thank you for your feedback';
        }

        public function action_add_report(){
            $res='';
            $text= trim($_POST['bug']);

            if($text===''){
                echo   $res= 'plese fill thefield';
            }

            $filename = 'E:/xampp/htdocs/System_of_electronic_document_circulation/bugs.txt';

            $file = fopen($filename, 'a');

            fwrite($file, $text.'--'.$_COOKIE['username'].'#' . PHP_EOL);
            fclose($file);
            echo   $res='Thank you for your feedback';
        }
        
    }

?>