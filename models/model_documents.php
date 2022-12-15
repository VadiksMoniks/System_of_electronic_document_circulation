<?php
    include 'languages.php';
    class Model_Documents extends Model{

  /*      function downloadBlank($name){
            $file = 'E:/xampp/htdocs/System_of_electronic_document_circulation/'.$name.'.pdf';
            if(file_exists($file)){
                if(ob_get_level()){
                    ob_end_clean();
                }
            //download
                //$blank ='ticket.png';
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                flush(); // Flush system output buffer
                readfile($file);
                exit;
            
            }
        }*/

        public function generateDoc($data, $lang){
            /*
                значит смотри сюда, урод. ты когда эту хуету кодил, вызывал функцию '( $userSignature = imagecreatefrompng($removeSig);)' строка 105 - так вот она толбко для пнг изображений, какой сюрприз блять. короче
                нужно либо создать переменную, которая будет хранить формат и потом вызывать функцию для этого формата или так же в переменную записать формат ,
                но потом ее конкатенировать с названием метода(хз можно ли так) и нужно глянуть в мануале, какие функции есть кропе png i jpeg
            */ 
            //
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            $data['initials']=trim($data['initials']);
            $data['group']=trim($data['group']);
            $data['recipient']=trim($data['recipient']);
            $data['text'] = trim($data['text']);
            if($data['initials']==""){
                return $$lang['docError1'];
            }
            else if($data['group']==""){
                return $$lang['docError1'];
            }

            else if($data['recipient']==""){
                return $$lang['docError1'];
            }

            else if($data['initials']===$data['recipient']){
                return $$lang['docError2'];
            }

            else if($data['text']==''){
                return $$lang['docError3'];
            }

            else if (empty($_FILES['file']['name'])){
                return $$lang['docError4'];
            }


            if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ\s\-`]+/',$data['initials'] )){
                return 'only ukr';
            }
            else if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ0-9\-]+/',$data['group'] )){
                return 'only ukr';
            }
            else if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ0-9\/\s\-,:.`]+/',$data['text'] )){
                return 'only ukr';
            }

            

            $filetype = new SplFileInfo($_FILES['file']['name']);
            
            if($filetype->getExtension() != 'png'){
                return $$lang['docError5'];
            }

            else{
                $dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/';
                $removeSig = $dir.basename($_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $removeSig);
               
            }

            $recipientMailSQL = parent::connection()->prepare('SELECT `mail` FROM `users` WHERE `username` =?');
            $recipientMailSQL->execute([$data['recipient']]);
            $recipientMail=$recipientMailSQL->fetch();
            if($recipientMail==null){
                return $$lang['wrongRecipient'];
            }

            else{

                //username
                $senderName=parent::connection()->prepare('SELECT `username` FROM `users` WHERE `mail`=?');
                $senderName->execute([$_COOKIE['username']]);
                $sName= $senderName->fetch();

                //

                $example = imagecreatefrompng('http://localhost/System_of_electronic_document_circulation/document_examples/canvas.png');
                $userSignature = imagecreatefrompng($removeSig);
                $file = 'http://localhost/System_of_electronic_document_circulation/document_examples/'.$data['name'].'.txt';
            // $handle = fopen($filename, "r");
                $filetext = mb_convert_encoding(file_get_contents($file), 'UTF-8');
                $filetext=preg_replace('/ПІБ/', $data['initials'], $filetext);
                $filetext=preg_replace('/ГРУПА/', $data['group'], $filetext);
                $filetext=preg_replace('/КОГО/', $data['recipient'], $filetext);
                $filetext=preg_replace('/ що я великий молодець і зробив цю курсову/', $data['text'], $filetext);
                $textarr = explode(';',$filetext);
                //fclose($handle);


                imagettftext($example, 15, 0, 450, 100, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[0]);
                imagettftext($example, 15, 0, 450, 140, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[1]);
                imagettftext($example, 15, 0, 350, 180, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[2]);
                imagettftext($example, 15, 0, 450, 240, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[3]);
                imagettftext($example, 15, 0, 380, 350, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[4]);
                imagettftext($example, 15, 0, 150, 400, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[5]);
                /*

                    З УКРАЇНСЬКОЮ РОЗКЛАДКОЮ З'ЯВЛЯЮТЬСЯ ДИВНІ СИМВОЛИ В ТЕКСТІ ПОКИ НЕ ЗНАЮ, ЯК ТО ВИПРАВИТИ
                */
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
                $picName=$sName->username.'_'.date("Ymd_His");
                imagepng($example, $data['name'].'_'.$picName.'.png');
                imagedestroy($example);
                imagedestroy($userSignature);
                $fName='E:/xampp/htdocs/System_of_electronic_document_circulation/'.$data['name'].'_'.$picName.'.png';

                unlink($removeSig);

                $sql = parent::connection()->prepare('INSERT INTO `docs` VALUES(?,?,?,?,?)');
                $sql->execute([NULL, $_COOKIE['username'], $data['recipient'], $fName, 'unsigned']);
    
                return $$lang['docMsg'];
            }

        }


        /*function downloadExample($docName){
            $dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/document_examples';
            $docName = $dir.$docName.'.txt';

            if(file_exists($docName)){
                //зробити пнг документу і перевести в пдф потім віддати користувачу
            }
            else{
                return "such file doesn't exists";
            }
        }*/




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