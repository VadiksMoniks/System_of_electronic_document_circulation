<?php
    include 'languages.php';
    class Model_Documents extends Model{

        public function showExample($document_name){

            if(isset($document_name)){
                if(trim($document_name)!=''){
                    $method_name='document_'.$document_name;
                    if(method_exists('Model_Documents',$method_name)){
                        return self::$method_name();
                    }
                    else{
                        return 'wrong document name';
                    }
                }
            }

        }


        public function generateDoc($data, $lang){
            /*
                значит смотри сюда, урод. ты когда эту хуету кодил, вызывал функцию '( $userSignature = imagecreatefrompng($removeSig);)' строка 105 - так вот она толбко для пнг изображений, какой сюрприз блять. короче
                нужно либо создать переменную, которая будет хранить формат и потом вызывать функцию для этого формата или так же в переменную записать формат ,
                но потом ее конкатенировать с названием метода(хз можно ли так) и нужно глянуть в мануале, какие функции есть кропе png i jpeg
            */ 
            //
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            //var_dump($data);
            $data['initials']=trim($data['initials']);
            $data['group']=trim($data['group']);
          //  $data['recipient']=trim($data['recipient']);
            $data['text'] = trim($data['text']);

            $slice = array_slice($data, 5, 4);

            foreach($slice as $key => $value){
                if($slice[$key]==""){
                    return $$lang['docError1'];
                }
            }
           // var_dump($slice);
           
           // if($data['mail']===$data['recipient']){
           //     return $$lang['docError2'];
          //  }            
            foreach($slice as $key => $value){
                if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ\s\-`]+/',$slice[$key] )){
                    return 'only ukr';
                }
            }

            if (empty($_FILES['file']['name'])){
                return $$lang['docError4'];
            }


           /* if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ\s\-`]+/',$data['initials'] )){
                return 'only ukr';
            }
            else if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ0-9\-]+/',$data['group'] )){
                return 'only ukr';
            }
            else if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ0-9\/\s\-,:.`]+/',$data['text'] )){
                return 'only ukr';
            }*/


            

            $filetype = new SplFileInfo($_FILES['file']['name']);
            
            if($filetype->getExtension() != 'png'){
                return $$lang['docError5'];
            }

            else{
                $dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/';
                $removeSig = $dir.basename($_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $removeSig);
               
            }

           /* $recipientMailSQL = parent::connection()->prepare('SELECT * FROM `users` WHERE `mail` =?');
            $recipientMailSQL->execute([$data['recipient']]);
            $recipientMail=$recipientMailSQL->fetch();
            if($recipientMail==false){
                return $$lang['wrongRecipient'];
            }*/

           // else{
                $method_name='document_'.$data['name'];
                if(method_exists($this,$method_name)){
                    return self::$method_name($data, $lang, $removeSig);
                }
                else{
                    return 'wrong document name';
                }
   
           // }

        }

        private function document_Accural_of_social_scholarship($data=null, $lang=null, $signature=null){

            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            $recipient = "username@infiz.khpi.edu.ua";

            if($data!=null && $lang!=null && $signature!=null){
                $senderName=parent::connection()->prepare('SELECT `username` FROM `users` WHERE `mail`=?');
                    $senderName->execute([$data['mail']]);
                    $sName= $senderName->fetch();


                    $example = imagecreatefrompng('http://localhost/System_of_electronic_document_circulation/document_examples/canvas.png');
                    $userSignature = imagecreatefrompng($signature);
                    $file = 'http://localhost/System_of_electronic_document_circulation/document_examples/'.$data['name'].'.txt';
                    $filetext = mb_convert_encoding(file_get_contents($file), 'UTF-8');
                    $filetext=preg_replace('/ПІБ/', $data['initials'], $filetext);
                    $filetext=preg_replace('/ГРУПА/', $data['group'], $filetext);
                   // $filetext=preg_replace('/КОГО/', $data['recipient'], $filetext);
                    $filetext=preg_replace('/ я великий молодець і зробив цю курсову/', " ".$data['text'], $filetext);
                    $textarr = explode(';',$filetext);


                    imagettftext($example, 15, 0, 450, 100, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[0]);
                    imagettftext($example, 15, 0, 450, 140, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[1]);
                    imagettftext($example, 15, 0, 350, 180, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[2]);
                    imagettftext($example, 15, 0, 450, 240, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[3]);
                    imagettftext($example, 15, 0, 380, 350, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[4]);
                    imagettftext($example, 15, 0, 150, 400, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[5]);

                    $text = str_split($textarr[6], 100);
                    $x=150;
                    $y=420;
                    for($i=0; $i<count($text); $i++){
                        if($i===0){
                            imagettftext($example, 15, 0, $x, $y, imagecolorallocate($example,0,0,0), 'arial.ttf', $text[$i]);
                        }
                        else{
                            imagettftext($example, 15, 0, $x, $y+($i*20), imagecolorallocate($example,0,0,0), 'arial.ttf', $text[$i]);
                        }
                        
                    }
                // 
                    imagettftext($example, 15, 0, 200, 800, imagecolorallocate($example,0,0,0), 'arial.ttf', date('d m Y'));
                    imagettftext($example, 15, 0, 200, 850, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[7]);
                    imagettftext($example, 15, 0, 300, 800, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[8]);
                    imagettftext($example, 15, 0, 650, 850, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[9]);
                    imagettftext($example, 15, 0, 550, 1100, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[10]);
                    imagecopy($example, $userSignature, 600, 700, 0, 0 ,126, 100);
                    $picName=$sName->username.'_'.date("Y-m-d_H-i-s");
                    imagepng($example, $data['name'].'_'.$picName.'.png');
                    imagedestroy($example);
                    imagedestroy($userSignature);
                    $fName='E:/xampp/htdocs/System_of_electronic_document_circulation/'.$data['name'].'_'.$picName.'.png';

                    unlink($signature);

                    $sql = parent::connection()->prepare('INSERT INTO `docs` VALUES(?,?,?,?,?)');
                    $sql->execute([NULL, $data['mail'], $recipient, $fName, 'unchecked']);
                    
                    return $$lang['docMsg'];
            }

            else{

                $example = imagecreatefrompng('http://localhost/System_of_electronic_document_circulation/document_examples/canvas.png');
                $file = 'http://localhost/System_of_electronic_document_circulation/document_examples/Accural_of_social_scholarship.txt';
               // $handle = fopen($filename, "r");
                $filetext = mb_convert_encoding(file_get_contents($file), 'UTF-8');
                $textarr = explode(';',$filetext);
                //fclose($handle);
                imagettftext($example, 15, 0, 450, 100, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[0]);
                imagettftext($example, 15, 0, 450, 140, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[1]);
                imagettftext($example, 15, 0, 350, 180, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[2]);
                imagettftext($example, 15, 0, 450, 240, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[3]);
                imagettftext($example, 15, 0, 380, 350, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[4]);
                imagettftext($example, 15, 0, 150, 400, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[5]);
                imagettftext($example, 15, 0, 150, 450, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[6]);
                imagettftext($example, 15, 0, 200, 850, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[7]);
                imagettftext($example, 15, 0, 300, 800, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[8]);
                imagettftext($example, 15, 0, 650, 850, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[9]);
                imagettftext($example, 15, 0, 550, 1100, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[10]);
                
            
                imagepng($example, 'ticket.png');
                imagedestroy($example);
            
                 return '<img src="http://localhost/System_of_electronic_document_circulation/ticket.png">';

            }

        }

        private function document_voluntary_deduction($data=null, $lang=null, $signature=null)
        {
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';


            $recipient = "username@infiz.khpi.edu.ua";
            if($data!=null && $lang!=null && $signature!=null){

                if($data['studyingForm']=='daytime'){
                    $data['studyingForm']='денної';
                }
                else{
                    $data['studyingForm']='заочної';
                }
                


                $senderName=parent::connection()->prepare('SELECT `username` FROM `users` WHERE `mail`=?');
                    $senderName->execute([$data['mail']]);
                    $sName= $senderName->fetch();

                $example = imagecreatefrompng('http://localhost/System_of_electronic_document_circulation/document_examples/voluntary_deduction.png');
                $userSignature = imagecreatefrompng($signature);

                imagettftext($example, 30, 0, 1035, 209, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['course']);
                imagettftext($example, 25, 0, 1307, 209, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['group']);
                imagettftext($example, 20, 0, 825, 320, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['speciality']);
                imagettftext($example, 30, 0, 861, 375, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['studyingForm']);
                imagettftext($example, 20, 0, 805, 476, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['initials']);
                //imagettftext($example, 15, 0, 1045, 209, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['course']);
                $text = str_split($data['text'], 115);
                $x=305;
                $y=683;
                for($i=0; $i<count($text); $i++){
                    if($i===0){
                        imagettftext($example, 30, 0, $x, $y, imagecolorallocate($example,0,0,0), 'arial.ttf', $text[$i]);
                    }
                    else{
                        imagettftext($example, 30, 0, $x, $y+($i*80), imagecolorallocate($example,0,0,0), 'arial.ttf', $text[$i]);
                    }
                    
                }

                imagettftext($example, 30, 0, 275, 1045, imagecolorallocate($example,0,0,0), 'arial.ttf', date('d'));
                imagettftext($example, 30, 0, 500, 1045, imagecolorallocate($example,0,0,0), 'arial.ttf', date('m'));
                imagecopy($example, $userSignature, 1329, 965, 0, 0 ,126, 100);

                $picName=$sName->username.'_'.date("Y-m-d_H-i-s");
                imagepng($example, $data['name'].'_'.$picName.'.png');
                imagedestroy($example);
                imagedestroy($userSignature);
                $fName='E:/xampp/htdocs/System_of_electronic_document_circulation/'.$data['name'].'_'.$picName.'.png';

                unlink($signature);
                
                $sql = parent::connection()->prepare('INSERT INTO `docs` VALUES(?,?,?,?,?)');
                $sql->execute([NULL, $data['mail'], $recipient, $fName, 'unchecked']);

                return $$lang['docMsg'];
            }

            else{
                return '<img src="http://localhost/System_of_electronic_document_circulation/document_examples/voluntary_deduction.png">';
            }
        }


        public function recipientList($searchingName){
            $searchingName = trim($searchingName);
            if($searchingName!=''){
                $sql = parent::connection()->prepare('SELECT `mail` FROM `users` WHERE `mail` LIKE ?');
                $sql->execute(["%$searchingName%"]);
                $output='<ul>';
                $result = $sql->fetchAll();
                if($result!=NULL){
                    
                    foreach($result as $name){
                        $output.='<a name='.$name->mail.' class="variants"><li style="font-size:15px; font-color:#000;">'.$name->mail.'</li></a>';
                    }
                }
                else{
                    $output.= '<li style="font-size:15px;font-color:#000;">No such user</li>';
                }
                 $output.='</ul>';
                 return $output;
            }
        }

    }

?>