<?php
    namespace Models;

    session_start();

    use Core\Model;

    class Model_Directorate extends \Core\Model{

        public function signIn($data, $lang = 'ua')
        {
          include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
          
          $this->answer['answer'] = $this->checkEmptity($data, $lang);
          if($this->answer['answer']!=1){
              return json_encode($this->answer);
          }

            //$sql = $this->pdo->prepare("SELECT * FROM `directorate_accounts` WHERE `mail` =?");
            //$sql->execute([$data['mail']]);
            $result = self::makeQuery('select', "SELECT * FROM `directorate_accounts` WHERE `mail` =?", $data['mail'],'fetch');

            if($result===false){
                $this->answer['answer'] = self::returnMessage('errorSignIn', $$lang);
                return json_encode($this->answer); 
            }

            else{
                if(password_verify($data['password'], $result->password)==0)
                {
                    $this->answer['answer'] = self::returnMessage('errorSignIn', $$lang);
                    return json_encode($this->answer); 
                }
                else{
                    if(password_verify($data['ip'], $result->ip)==1){
                       // return "yes";
                        $_SESSION['directorate'] = $result->username;
                        $this->answer['answer'] =  self::returnMessage('okMsg', $$lang);
                        return json_encode($this->answer);
                    }
                    else{
                        $this->answer['answer'] = "access denied";
                        return json_encode($this->answer);
                    }
                }
            }
        }

        public function documents_for_signature($user)
        {
            $list = array();
            $user = trim($user);

            if($user==="")
            {
                header("Location: http://localhost/System_of_electronic_document_circulation/index.php");
            }

            //$sqlUser = $this->pdo->prepare("SELECT * FROM `directorate_accounts` WHERE `username`=?");
            //$sqlUser->execute([$user]);
            $resultUser = self::makeQuery('select', "SELECT * FROM `directorate_accounts` WHERE `username`=?", $user,'fetch');


            //$sql = $this->pdo->prepare("SELECT `reciever`, `already_signed`, `document_name` FROM `docs` WHERE `status`=?");
            //$sql->execute(["unsigned"]);

            $result = self::makeQuery('select', "SELECT `reciever`, `already_signed`, `document_name` FROM `docs` WHERE `status`=?", "unsigned", 'fetchAll',\PDO::FETCH_ASSOC);
            if($result===false){
                return "Something went wrong";
            }
            for($i=0; $i<count($result); $i++){
                $recievers = explode(',', $result[$i]['reciever']);
                $userIndex = array_search($resultUser->mail, $recievers);
                if($userIndex===false)
                {
                    continue;
                }
                else
                {
                    if($userIndex==0)
                    {  
                        if($result[$i]['already_signed']===NULL){
                            array_push($list, basename($result[$i]['document_name'], ".png"));
                        }
                    }
                    else
                    {
                        if($result[$i]['already_signed']!=NULL)
                        {
                            $already_signed = explode(',',$result[$i]['already_signed']);//Документ будут видеть ВСЕ кто еще не подписал его
                            if(array_search($resultUser->mail, $already_signed)==false && count($already_signed)==$userIndex)
                            {
                                array_push($list, basename($result[$i]['document_name'], ".png"));
                            }
                        }
                    }
                }
            }
            return $list;
        }

        public function showDoc($documentName)
        {
            if(file_exists("E:/xampp/htdocs/System_of_electronic_document_circulation/".$documentName.".png")){
                //return '<img src="http://localhost/System_of_electronic_document_circulation/document_examples/'.$documentName.'_example.png">';
                array_push($this->answer,['answer'=>$documentName, 'type'=>"image"]);
                return $this->answer;
            }
            else{
                array_push($this->answer,['answer'=>"Wrong name", 'type'=>"msg"]);
                return $this->answer; 
            }
        }

        public function signDocument($data, $directorate)
        {
            if(!isset($data['document_name']))
            {
                return "wrong document name";
            }
            else if(!isset($directorate))
            {
                header("Location: http://localhost/System_of_electronic_document_circulation/index.php");
            }
            else if(trim($data['document_name'])==="")
            {
                return "wrong document name";
            }

            if (empty($_FILES['file']['name'])){
                return "add your signature";
            }
            $path= "E:/xampp/htdocs/System_of_electronic_document_circulation/".$data['document_name'].".png";
            $filetype = new \SplFileInfo($_FILES['file']['name']);
            
            if($filetype->getExtension() != 'png'){
                if(isset($_FILES['file']['tmp_name'])){
                    unlink($_FILES['file']['tmp_name']);
                }
                return "your signature must be offtype PNG";
            }

            else{
                $dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/';
                $removeSig = $dir.basename($_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $removeSig);
               
            }

            //$sql = $this->pdo->prepare("SELECT * FROM `docs` WHERE `document_name`=?");
            //$sql->execute([$path]);
            $result =self::makeQuery('select', "SELECT * FROM `docs` WHERE `document_name`=?", $path, 'fetch');
            if($result===false){
                return "something went wrong";
            }

            if($result->type==="templated"){
                return $this->signTemplated($data['document_name'],$directorate, $path, $removeSig, $result);
            }
            else{
                return $this->signHandwritten($data['document_name'],$directorate, $path, $removeSig, $result);
            }

        }

        private function signTemplated($documentName, $directorate, $docPath, $signaturePath, $docInfo)//Не працює накладання тексту ніде у цій функції, ТРЕБА ВИПРАВИТИ!!!
        {
            //$start = microtime(true);
            $pointsOfSignatures = [ 
                [
                    [921, 1159],
                    [281, 1284],
                    [469, 1278]
                ],
                [
                    [1255, 1400],
                    [273, 1910],
                    [469, 1910]
                ], 
                [
                    [1181, 1640],
                    [959, 1750],
                    [1135, 1750]
                ], 
                [
                    [1181, 1820],
                    [959, 1910],
                    [1111, 1910]
                ],
                [
                    [211, 135]
                    ]
                ];

            $document = imagecreatefrompng($docPath);
            $directorateSignature = imagecreatefrompng($signaturePath);

            //$sqlMail = $this->pdo->prepare("SELECT `mail` FROM `directorate_accounts` WHERE `username` =?");
            //$sqlMail->execute([$directorate]);
            $directorateMail = self::makeQuery('select', "SELECT `mail` FROM `directorate_accounts` WHERE `username` =?",$directorate, 'fetch');

            if($docInfo->already_signed===NULL){//zav kafedry
                imagecopy($document, $directorateSignature, 525, 1640, 0, 0 ,126, 100);
                imagettftext($document, 30, 0, 273, 1750, imagecolorallocate($document,0,0,0), 'arial.ttf', date('d'));
                imagettftext($document, 30, 0, 417, 1750, imagecolorallocate($document,0,0,0), 'arial.ttf', date('m'));

                $sql = $this->pdo->prepare("UPDATE `docs` SET `already_signed` = ? WHERE `document_name` = ?");
                $sql->execute([$directorateMail->mail,$docInfo->document_name]);
            }
            else{

                    $already_signed = explode(',', $docInfo->reciever);   
                    $userIndex = array_search($directorateMail->mail, $already_signed);
                    $index = $userIndex-1;
                    if($userIndex!=5){
                        imagecopy($document, $directorateSignature, $pointsOfSignatures[$index][0][0], $pointsOfSignatures[$index][0][1], 0, 0 ,126, 100);
                        imagettftext($document, 30, 0, $pointsOfSignatures[$index][1][0], $pointsOfSignatures[$index][1][1], imagecolorallocate($document,0,0,0), 'arial.ttf', date('d'));
                        imagettftext($document, 30, 0, $pointsOfSignatures[$index][2][0], $pointsOfSignatures[$index][2][1], imagecolorallocate($document,0,0,0), 'arial.ttf', date('m'));

                        $sql = $this->pdo->prepare("UPDATE `docs` SET `already_signed` = ? WHERE `document_name` = ?");
                        $sql->execute([$docInfo->already_signed.','.$directorateMail->mail,$docInfo->document_name]);
                    }

                    else{
                        imagecopy($document, $directorateSignature, $pointsOfSignatures[$index][0][0], $pointsOfSignatures[$index][0][1], 0, 0 ,126, 100);
                        imagepng($document, $docPath);
                        $newFile = new \Imagick();
                        $newFile->readImage($docPath);
                        //$newFile->readImage();
                        $newFile->setFormat('pdf');
                        $fName = 'E:/xampp/htdocs/System_of_electronic_document_circulation/'.basename($docPath, '.png').".".$newFile->getFormat();
                        $newFile->writeImage($fName);

                        $sql = $this->pdo->prepare("UPDATE `docs` SET `document_name` = ?, `already_signed` = ?, `status` = ? WHERE `document_name` = ?");
                        $sql->execute([$fName,$docInfo->already_signed.','.$directorateMail->mail,"signed",$docInfo->document_name]);
                       // imagedestroy($directorateSignature);
                       // unlink($removeSig);
                        unlink($docPath);
                        //return "Thank You";
                       // $sqlName = $this->pdo->prepare("SELECT `sender` FROM `docs` WHERE `document_name` =?");
                       // $sqlName->execute([$fName]);
                        $name = self::makeQuery('select', "SELECT `sender` FROM `docs` WHERE `document_name` =?", $fName, 'fetch');
                        
                        //$sqlSender = $this->pdo->prepare("SELECT * FROM `users` WHERE `username` =?");
                        //$sqlSender->execute([$name->sender]);
                        $Sender = self::makeQuery('select', "SELECT * FROM `users` WHERE `username` =?",$name->sender, 'fetch');
                        if($Sender->notification ==1){
                            $header = "Ваш документ готовий для завантаження!";
                            $message = "Документ ".basename($fName, '.pdf')." щойно було підписано. Перейдіть у розділ 'Завантажити' у вашому профілі для того, аби скачати документ.";
                            $this->sendMail($Sender->mail, $header, $message);

                        }
                    }
                      
                }

            $img = "E:/xampp/htdocs/System_of_electronic_document_circulation/".$documentName.".png";
            //unlink($img);
            imagepng($document, $img);
            imagedestroy($document);
            imagedestroy($directorateSignature);
            unlink($signaturePath);
            $deleteImg = "E:/xampp/htdocs/System_of_electronic_document_circulation/".$documentName.".pdf";
            //$sqlStatus = $this->pdo->prepare("SELECT `status` FROM `docs` WHERE `document_name` = ?");
            //$sqlStatus->execute([$deleteImg]);
            $status = self::makeQuery('select', "SELECT `status` FROM `docs` WHERE `document_name` = ?", $deleteImg, 'fetch');
            if($status!=false && $status->status==="signed"){
                unlink($img);
            }
            //
            return "Thank You";
            //'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.';

        }

        private function signHandwritten($documentName, $directorate, $docPath, $signaturePath, $docInfo)
        {
            //$sqlMail = $this->pdo->prepare("SELECT `mail` FROM `directorate_accounts` WHERE `username` =?");
            //$sqlMail->execute([$directorate]);
            $directorateMail = self::makeQuery('select', "SELECT `mail` FROM `directorate_accounts` WHERE `username` =?", $directorate, 'fetch');

            $document = imagecreatefrompng($docPath);
            $directorateSignature = imagecreatefrompng($signaturePath);
            
            imagecopy($document, $directorateSignature, 211, 135, 0, 0 ,126, 100);
            imagepng($document, $docPath);
            $newFile = new \Imagick();
            $newFile->readImage($docPath);
                        //$newFile->readImage();
            $newFile->setFormat('pdf');
            $fName = 'E:/xampp/htdocs/System_of_electronic_document_circulation/'.basename($docPath, '.png').".".$newFile->getFormat();
            $newFile->writeImage($fName);

            $sql = $this->pdo->prepare("UPDATE `docs` SET `document_name` = ?, `already_signed` = ?, `status` = ? WHERE `document_name` = ?");
            $sql->execute([$fName,$directorateMail->mail,"signed",$docInfo->document_name]);
            imagedestroy($document);
            imagedestroy($directorateSignature);
                       // imagedestroy($directorateSignature);
                       // unlink($removeSig);
            unlink($docPath);
            unlink($signaturePath);

           // $sqlName = $this->pdo->prepare("SELECT `sender` FROM `docs` WHERE `document_name` =?");
           // $sqlName->execute([$fName]);
            $name =self::makeQuery('select', "SELECT `sender` FROM `docs` WHERE `document_name` =?", $fName, 'fetch');
            
           // $sqlSender = $this->pdo->prepare("SELECT * FROM `users` WHERE `username` =?");
           // $sqlSender->execute([$name->sender]);
            $Sender = self::makeQuery('select', "SELECT * FROM `users` WHERE `username` =?", $name->sender, 'fetch');

            if($Sender->notification == 1){
                $header = "Ваш документ готовий для завантаження!";
                $message = "Документ ".basename($fName, '.pdf')." щойно було підписано. Перейдіть у розділ 'Завантажити' у вашому профілі для того, аби скачати документ.";
                $this->sendMail($Sender->mail, $header, $message);
            }

            return "Thank You";
        }

    }
