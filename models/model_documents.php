<?php

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

        function generateDoc($data){
            //
            $data['initials']=trim($data['initials']);
            $data['group']=trim($data['group']);
            $data['recipient']=trim($data['recipient']);

            if($data['initials']==""){
                return 'You must fill all the fields';
            }
            else if($data['group']==""){
                return 'You must fill all the fields';
            }

            else if($data['recipient']==""){
                return 'You must fill all the fields';
            }

            else if($data['initials']===$data['recipient']){
                return "You can't send documents to yourself";
            }

            else if (empty($_FILES['file']['name'])){
                return "You must add your signature";
            }
            

            $filetype = new SplFileInfo($_FILES['file']['name']);
            
            if($filetype->getExtension() != 'png'){
                return 'Filetype must be only PNG';
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
                return "There is no such user who you are trying to send this document ";
            }

            else{

                $example = imagecreatefrompng('http://localhost/System_of_electronic_document_circulation/document_examples/canvas.png');
                $userSignature = imagecreatefrompng($removeSig);
                $file = 'http://localhost/System_of_electronic_document_circulation/document_examples/'.$data['name'].'.txt';
            // $handle = fopen($filename, "r");
                $filetext = mb_convert_encoding(file_get_contents($file), 'UTF-8');
                $filetext=preg_replace('/ПІБ/', $data['initials'], $filetext);
                $filetext=preg_replace('/ГРУПА/', $data['group'], $filetext);
                $filetext=preg_replace('/КОГО/', $data['recipient'], $filetext);
                $textarr = explode(';',$filetext);
                //fclose($handle);
                imagettftext($example, 15, 0, 250, 100, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[0]);
                imagettftext($example, 15, 0, 50, 140, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[1]);
                imagettftext($example, 15, 0, 50, 180, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[2]);
                imagecopy($example, $userSignature, 350, 600, 0, 0 ,126, 100);
                $picName=$data['initials'].'_'.date("Ymd_His");
                imagepng($example, $data['name'].'_'.$picName.'.png');
                imagedestroy($example);
                imagedestroy($userSignature);
                $fName='E:/xampp/htdocs/System_of_electronic_document_circulation/'.$data['name'].'_'.$picName.'.png';
                /*$newFile = new Imagick();
                $newFile->readImage('E:/xampp/htdocs/System_of_electronic_document_circulation/'.$picName.'.png');
                //$newFile->readImage();
                $newFile->setFormat('pdf');
                $fName = 'E:/xampp/htdocs/System_of_electronic_document_circulation/'.$data['name'].'_'.$picName.".".$newFile->getFormat();
                $newFile->writeImage($fName);*/
                //return $data['initials'];
                unlink($removeSig);
                /*$recipientMailSQL = parent::connection('SELECT `mail` FROM `users` WHERE `username` =?');
                $recipientMailSQL->execute([$data['recipient']]);
                $recipientMail=$recipientMailSQL->fetch();*/
                $sql = parent::connection()->prepare('INSERT INTO `docs` VALUES(?,?,?,?,?)');
                $sql->execute([NULL, $_COOKIE['username'], $data['recipient'], $fName, 'unsigned']);
    
                return "Your document was generated and sended to recipient to sign it";
            }

        }

        /*function sign_document($docName){

            $filetype = new SplFileInfo($_FILES['file']['name']);
            
            if($filetype->getExtension() != 'png'){
                return 'Filetype must be only PNG';
            }

            else{
                $dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/';
                $removeSig = $dir.basename($_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $removeSig);
            }

            $example = imagecreatefrompng('http://localhost/System_of_electronic_document_circulation/document_examples/canvas.png');
            $userSignature = imagecreatefrompng($removeSig);

            imagecopy($example, $userSignature, 150, 600, 0, 0 ,126, 100);
            $picName=$dir.$docName;
            imagepng($example, $picName);
            imagedestroy($example);
            imagedestroy($userSignature);

            $newFile = new Imagick();
            $newFile->readImage($picName);
            //$newFile->readImage();
            $newFile->setFormat('pdf');
            $fName = basename($picName, '.png').".".$newFile->getFormat();
            $newFile->writeImage($fName);
            unlink($removeSig);
            unlink($picName);

            $sql = parent::connection()->prepare('UPDATE `docs` SET `status`=?');
            $sql->execute(['signed']);
            return "Document was signed";
        }*/

    }

?>