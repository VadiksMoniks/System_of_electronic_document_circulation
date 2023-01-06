<?php

    class Model_Account extends Model
    {
        public function registre($data, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            //var_dump($_POST);
            $data['mail']=trim($data['mail']);
            $data['username']=trim($data['username']);
            $data['password']=trim($data['password']);
            $pattern='/[a-zA-Z_\s.]+@infiz.khpi.edu.ua/';

            if($data['mail']==""){
                return $$lang['errorRegEmptyMail'];
            }

            else if($data['username']==""){
                return $$lang['errorRegEmptyName'];
            }

            else if($data['password']==""){
                return $$lang['errorRegEmptyPass'];
            }

            else{

                if(preg_match($pattern, $data['mail'])!=1){
                    return $$lang['errorRegDomain'];
                }
                $password = password_hash($data['password'], PASSWORD_DEFAULT);

                $sql = parent::connection()->prepare("SELECT * FROM `users` WHERE `username` =?");
                $sql->execute([$data['username']]);
                $result = $sql->fetchAll();
                if($result!=null){
                    return $$lang['errorRegununiqName'];//checking username's unicity
                }
                else{
                    $sql = parent::connection()->prepare("SELECT * FROM `users` WHERE `mail` =?");
                    $sql->execute([$data['mail']]);
                    $result = $sql->fetchAll();
                    if($result!=null){
                        return $$lang['errorRegununiqMail'];//checking mail unicity
                    }
                    else{
                            $sql = parent::connection()->prepare("INSERT INTO `users` VALUES(?,?,?,?)");
                            $sql->execute([NULL, $data['mail'], $data['username'], $password]);
                        if($data['keepSigned']==='keep'){
                            setcookie('username', $data['mail'],strtotime( '+30 days' ) ,'/');
                        }
                        else if($data['keepSigned']==='no'){
                            setcookie('username', $data['mail'],strtotime( '+1 day' ) ,'/');
                        }
                        
                        return $$lang['okMsg'];
                    }
                }

            }

        }

        public function signIn($data, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            $data['mail']=trim($data['mail']);
            $data['password']=trim($data['password']);

            if($data['mail']==""){
                return $$lang['errorRegEmptyMail'];
            }

            else if($data['password']==""){
                return $$lang['errorRegEmptyPass'];
            }

            else{
                $sql = parent::connection()->prepare("SELECT * FROM `users` WHERE `mail` =?");
                $sql->execute([$data['mail']]);
                $result = $sql->fetch();
                if($result!=NULL){
                    if(password_verify($data['password'], $result->password)==1){
                        //$_SESSION['user'] = $data['username'];
                        if($data['keepSigned']==='keep'){
                            setcookie('username', $data['mail'],strtotime( '+30 days' ) ,'/');
                        }
                        else if($data['keepSigned']==='no'){
                            setcookie('username', $data['mail'],strtotime( '+1 day' ) ,'/');
                        }
                        return $$lang['okMsg'];
                    }
                    else{
                        return $$lang['errorSignIn'];
                    }
                }
                else{
                    return $$lang['errorSignIn'];
                }
            }
        }
        
        public function changePass($data){
            $data['oldPass'] = trim($data['oldPass']);
            $data['newPass'] = trim($data['newPass']);
            if($data['oldPass']!=''){
                if($data['newPass']!=''){
                    $sql = parent::connection()->prepare("SELECT `password` FROM `users` WHERE `mail` =?");
                    $sql->execute([$data['user']]);
    
                    $result = $sql->fetch();
                    if($result!=NULL){
                        if(password_verify($data['oldPass'], $result->password)){
                            $newPass = password_hash($data['newPass'], PASSWORD_DEFAULT);
                            $sql = parent::connection()->prepare("UPDATE `users` SET `password`=? WHERE `mail`=?");
                            $sql->execute([$newPass, $data['user']]);
    
                            return 'Password was changed';
                        }
                        else{
                            return 'Inncorect old password';
                        }
                    }
                }
                else{
                    return "password field can't be empty";
                }
            }
            return "password field can't be empty";
        }

        public function signOut(){
            if(isset($_COOKIE["username"])){
                setcookie('username', 'a', 1, '/');
                //session_destroy();
                header("Location: http://localhost/System_of_electronic_document_circulation/index.php");
            }
        }


        public function downloadBlank($name){
            
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
        }

        public function historyList($user, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            $answer ='';
            if(!empty($user)){
                $sql= parent::connection()->prepare("SELECT * FROM `docs` WHERE `sender`=?");
                $sql->execute([$user]);
                $result=$sql->fetchAll(PDO::FETCH_ASSOC);
                if($result!=NULL){
                    for($i=0; $i<count($result); $i++){
                            if($result[$i]['status']=="unsigned"){
                                $answer.='<a href="http://localhost/System_of_electronic_document_circulation/index.php/account/showDoc?name='.basename($result[$i]["document_name"]).'"><p>'.basename($result[$i]['document_name']).'</p></a> <button value="'.$result[$i]["document_name"].'" class="btn">Delete record</button><br/>';
                            }
                            else if($result[$i]['status']=="signed"){
                                $answer.='<p>'.basename($result[$i]['document_name']).'</p><br/>';
                            }
                            else{
                                $answer.='<a href="http://localhost/System_of_electronic_document_circulation/index.php/account/showDoc?name='.basename($result[$i]["document_name"]).'"><p>'.basename($result[$i]['document_name']).'</p></a><br/>';
                            }

                    }
                    
                    return $answer;
                }
                else{
                    return $$lang['Msghistory'];
                }
            }
        
            return "Wrong user data";
        }

        public function dwnlist($user, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            $answer ='';
            if(!empty($user)){
                $sql= parent::connection()->prepare("SELECT `document_name` FROM `docs` WHERE `status`='signed' AND `sender`=?");
                $sql->execute([$user]);
                $result=$sql->fetchAll(PDO::FETCH_ASSOC);
                if($result!=NULL){
                    for($i=0; $i<count($result); $i++){
                        $answer.='<a href="http://localhost/System_of_electronic_document_circulation/index.php/account/download?name='.basename($result[$i]['document_name'], '.pdf').'">'.basename($result[$i]['document_name']).'</a><br/>';
                    }
                    return $answer;
                }
                else{
                    return $$lang['Msgdwn'];
                }
            }
        
            return "Wrong user data";
            
        }

        public function signList($user, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            $answer='';
            $sql= parent::connection()->prepare("SELECT `username` FROM `users` WHERE `mail`=?");
            $sql->execute([$user]);

            $recieverMail=$sql->fetch();

            if($recieverMail!=null){
                $sql= parent::connection()->prepare("SELECT `document_name` FROM `docs` WHERE `status`='unsigned' AND `reciever`=?");
                $sql->execute([$recieverMail->username]);
                $result=$sql->fetchAll(PDO::FETCH_ASSOC);
                if($result!=NULL){
                    for($i=0; $i<count($result); $i++){
                        $answer.='<a href="http://localhost/System_of_electronic_document_circulation/index.php/account/sign?name='.basename($result[$i]['document_name'], '.pdf').'">'.basename($result[$i]['document_name']).'</a><br/>';
                    }
                    return $answer;
                }
                else{
                    return $$lang['Msgsign'];
                }
            }

            return "Wrong user data";
        }

        public function show_doc($docName, $lang){//now it can return also a msg from admin if doc was deleted by admins
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            if(file_exists('E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName)){
                return '<img src="http://localhost/System_of_electronic_document_circulation/'.$docName.'">';
            }
            else{
               // return $$lang['show_docError'];
                $msgSQL = parent::connection()->prepare("SELECT `status` FROM `docs` WHERE `document_name` = ?");
                $msgSQL->execute(['E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName]);
                $msg = $msgSQL->fetch();
                if(!$msg){
                     return $$lang['show_docError'];
                }
                
                else{
                    if($msg->status!='unsigned' && $msg->status!='signed'){

                        $deleteRecord = parent::connection()->prepare("DELETE FROM `docs` WHERE `document_name` = ?");
                        $deleteRecord->execute(['E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName]);

                        return '<p>'.$msg->status.'</p>';
                    }
                   
                }
               
            }
        }


        public function sign_document($docName, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            $filetype = new SplFileInfo($_FILES['file']['name']);
            
            if($filetype->getExtension() != 'png'){
                return $$lang['sign_documentError'];
            }

            else{
                $dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/';
                $removeSig = $dir.basename($_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $removeSig);
            }

            $example = imagecreatefrompng('E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName);
            $userSignature = imagecreatefrompng($removeSig);

            imagecopy($example, $userSignature, 600, 950, 0, 0 ,126, 100);
            $picName=$dir.$docName;
            imagepng($example, $picName);
            imagedestroy($example);
            imagedestroy($userSignature);

            $newFile = new Imagick();
            $newFile->readImage($picName);
            //$newFile->readImage();
            $newFile->setFormat('pdf');
            $fName = 'E:/xampp/htdocs/System_of_electronic_document_circulation/'.basename($picName, '.png').".".$newFile->getFormat();
            $newFile->writeImage($fName);
            unlink($removeSig);
            unlink($picName);

            $sql = parent::connection()->prepare('UPDATE `docs` SET `status`=?, `document_name`=? WHERE `document_name`=?');
            $sql->execute(['signed',$fName, 'E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName]);
            return $$lang['sign_documentMsg'];
        }


        public function deleteDocument($docName, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            $sql= parent::connection()->prepare("SELECT * FROM `docs` WHERE `document_name`=? AND `sender`=?");
            $sql->execute([$docName, $_COOKIE['username']]);
            $result = $sql->fetchAll();
            if($result==NULL){
                return $$lang['deleteDocError1'];
            }

            else{
                if(file_exists($docName)){
                    unlink($docName); 
                    $del=parent::connection()->prepare("DELETE FROM `docs` WHERE `document_name`=? AND `sender`=?");
                    $del->execute([$docName,$_COOKIE['username']]);
                    return $$lang['deleteDocMsg'];
                }
                else{
                    return $$lang['deleteDocError2'];
                }

            
            }

        
        } 

    }

?>