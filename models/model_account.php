<?php
    include_once 'E:/xampp/htdocs/System_of_electronic_document_circulation/core/model.php';
    
    class Model_Account extends Model
    {
        public function registre($data){
            //var_dump($_POST);
            $data['mail']=trim($data['mail']);
            $data['username']=trim($data['username']);
            $data['password']=trim($data['password']);
            $pattern='/[\w]+@infiz.khpi.edu.ua/';

            if($data['mail']==""){
                return "mail field can't be empty";
            }

            else if($data['username']==""){
                return "username field can't be empty";
            }

            else if($data['password']==""){
                return "password field can't be empty";
            }

            else{

                if(preg_match($pattern, $data['mail'])!=1){
                    return "Sorry but you can't use any othe e-mails except your corporate mail addres that ends on '@infiz.khpi.edu.ua'. We are working on adding more domains in future updates";
                }
                $password = password_hash($data['password'], PASSWORD_DEFAULT);

                $sql = parent::connection()->prepare("SELECT * FROM `users` WHERE `username` =?");
                $sql->execute([$data['username']]);
                $result = $sql->fetchAll();
                if($result!=null){
                    return "Such username is allready using";//checking username's unicity
                }
                else{
                    $sql = parent::connection()->prepare("SELECT * FROM `users` WHERE `mail` =?");
                    $sql->execute([$data['mail']]);
                    $result = $sql->fetchAll();
                    if($result!=null){
                        return "Such e-mail address is allready using";//checking mail unicity
                    }
                    else{
                       // if(!isset($seal)){
                            $sql = parent::connection()->prepare("INSERT INTO `users` VALUES(?,?,?,?,?,?,?)");
                            $sql->execute([NULL, $data['mail'], $data['username'], $password, $data['status'], NULL, NULL]);
                            //move_uploaded_file($_FILES['filename']['tmp_name'], $target_dir);
                      //  }
                      //  else{
                       //     $sql = parent::connection()->prepare("INSERT INTO `users` VALUES(?,?,?,?,?,?,?)");
                       //     $sql->execute([NULL, $_POST['mail'], $_POST['username'], $password, $_POST['status'], $signature, NULL]);
                       // }

                        setcookie('username', $data['mail'],strtotime( '+30 days' ) ,'/');
                        return "OK";
                    }
                }

            }

        }

        public function signIn($data){

            $data['mail']=trim($data['mail']);
            $data['password']=trim($data['password']);

            if($data['mail']==""){
                return "'mail' field can't be empty";
            }

            else if($data['password']==""){
                return "'password' field can't be empty";
            }

            else{
                $sql = parent::connection()->prepare("SELECT * FROM `users` WHERE `mail` =?");
                $sql->execute([$data['mail']]);
                $result = $sql->fetch();
                if($result!=NULL){
                    if(password_verify($data['password'], $result->password)==1){
                        //$_SESSION['user'] = $data['username'];
                        setcookie('username', $result->mail,strtotime( '+30 days' ), '/');
                        return "OK";
                    }
                    else{
                        return "WRONG USERNAME OR PASSWORD";
                    }
                }
                else{
                    return "WRONG USERNAME OR PASSWORD";
                }
            }
        }

        public function signOut(){
            if(isset($_COOKIE["username"])){
                setcookie('username', 'a', 1, '/');
                //session_destroy();
                header("Location: http://localhost/System_of_electronic_document_circulation/index.php");
            }
        }

      /*  public function newMessages(){

            //$mailSQL = parent::connection()->prepare('SELECT * FROM `users` WHERE `mail`=?');
            //$mailSQL->execute([$_COOKIE['username']]);

            //$mail = $mailSQL->fetch();

            $newMsg = NULL;
            $sql = parent::connection()->prepare('SELECT * FROM `docs` WHERE `reciever`=?');
            $sql->execute([$_COOKIE['username']]);
            $result = $sql->fetch();

            if($result!=NULL){

                $newMsg+= count($result);
                
            }

            $sql = parent::connection()->prepare('SELECT * FROM `docs` WHERE `sender`=?');
            $sql->execute([$_COOKIE['username']]);
            $result = $sql->fetch();

            if($result!=null){
                $newMsg+= count($result);
            }

            return $newMsg;
        }*/

        function downloadBlank($name){
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

        function historyList($user){
            $answer ='';
            if(!empty($user)){
                $sql= parent::connection()->prepare("SELECT * FROM `docs` WHERE `sender`=?");
                $sql->execute([$user]);
                $result=$sql->fetchAll(PDO::FETCH_ASSOC);
                if($result!=NULL){
                    for($i=0; $i<count($result); $i++){
                        if($result[$i]['status']=="unsigned"){
                            $answer.='<p>'.basename($result[$i]['document_name']).'</p> <button value="'.$result[$i]["document_name"].'" class="btn">Delete record</button><br/>';
                        }
                        else{
                            $answer.='<p>'.basename($result[$i]['document_name']).'</p><br/>';
                        }
                    }
                    
                    return $answer;
                }
                else{
                    return "No documents to download";
                }
            }
        
            return "Wrong user data";
        }

        function dwnlist($user){
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
                    return "No documents to download";
                }
            }
        
            return "Wrong user data";
            
        }

        function signList($user){
            $answer='';
            $sql= parent::connection()->prepare("SELECT `mail` FROM `users` WHERE `username`=?");
            $sql->execute([$user]);

            $recieverMail=$sql->fetch();

            if(!empty($user)){
                $sql= parent::connection()->prepare("SELECT `document_name` FROM `docs` WHERE `status`='unsigned' AND `reciever`=?");
                $sql->execute([$recieverMail]);
                $result=$sql->fetchAll(PDO::FETCH_ASSOC);
                if($result!=NULL){
                    for($i=0; $i<count($result); $i++){
                        $answer.='<a href="http://localhost/System_of_electronic_document_circulation/index.php/account/sign_page?name='.basename($result[$i]['document_name'], '.pdf').'">'.basename($result[$i]['document_name']).'</a><br/>';
                    }
                    return $answer;
                }
                else{
                    return "No documents to download";
                }
            }

            return "Wrong user data";
        }

        function show_doc($docName){
            if(file_exists('E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName)){
                return '<img src="http://localhost/System_of_electronic_document_circulation/'.$docName.'">';
            }
            else{
                return "Such file doesn't exist";
            }
        }


        function sign_document($docName){

            $filetype = new SplFileInfo($_FILES['file']['name']);
            
            if($filetype->getExtension() != 'png'){
                return 'Filetype must be only PNG';
            }

            else{
                $dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/';
                $removeSig = $dir.basename($_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $removeSig);
            }

            $example = imagecreatefrompng('E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName);
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
            $fName = 'E:/xampp/htdocs/System_of_electronic_document_circulation/'.basename($picName, '.png').".".$newFile->getFormat();
            $newFile->writeImage($fName);
            unlink($removeSig);
            unlink($picName);

            $sql = parent::connection()->prepare('UPDATE `docs` SET `status`=?, `document_name`=? WHERE `document_name`=?');
            $sql->execute(['signed',$fName, 'E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName]);
            return "Document was signed";
        }


        function deleteDocument($docName){
            $sql= parent::connection()->prepare("SELECT * FROM `docs` WHERE `document_name`=? AND `sender`=?");
            $sql->execute([$docName, $_COOKIE['username']]);
            $result = $sql->fetchAll();
            if($result==NULL){
                return 'No such document';
            }

            else{
                if(file_exists($docName)){
                    unlink($docName); 
                    $del=parent::connection()->prepare("DELETE FROM `docs` WHERE `document_name`=? AND `sender`=?");
                    $del->execute([$docName,$_COOKIE['username']]);
                    return 'Document was deleted';
                }
                else{
                    return "This file doesn't exist";
                }

            
            }

        
        } 

    }

?>