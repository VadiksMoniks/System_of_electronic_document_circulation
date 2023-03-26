<?php
session_start();
    class Model_Account extends Model
    {
        //private $data = array();

        public function registre($data, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            //var_dump($_POST);
            $data['mail']=trim($data['mail']);
            $data['username']=trim($data['username']);
            $data['password']=trim($data['password']);
            $pattern='/[a-zA-Z_\s.]+@infiz.khpi.edu.ua/';

            if($data['mail']==""){
                $this->data['answer']= $$lang['errorRegEmptyMail'];
                return json_encode($this->data);
            }

            else if($data['username']==""){
                $this->answer['answer']= $$lang['errorRegEmptyName'];
                return json_encode($this->answer);
            }

            else if($data['password']==""){
                $this->answer['answer']= $$lang['errorRegEmptyPass'];
                return json_encode($this->answer);
            }

            else{

                if(preg_match($pattern, $data['mail'])!=1){
                    $this->answer['answer']= $$lang['errorRegDomain'];
                    return json_encode($this->answer);
                }
                $password = password_hash($data['password'], PASSWORD_DEFAULT);

                $sql = parent::connection()->prepare("SELECT * FROM `users` WHERE `username` =?");
                $sql->execute([$data['username']]);
                $result = $sql->fetchAll();
                if($result!=null){
                    $this->answer['answer']= $$lang['errorRegununiqName'];//checking username's unicity
                    return json_encode($this->answer);
                }
                else{
                    $sql = parent::connection()->prepare("SELECT * FROM `users` WHERE `mail` =?");
                    $sql->execute([$data['mail']]);
                    $result = $sql->fetchAll();
                    if($result!=null){
                        $this->answer['answer']= $$lang['errorRegununiqMail'];//checking mail unicity
                        return json_encode($this->answer);
                    }
                    else{
                            $sql = parent::connection()->prepare("INSERT INTO `users` VALUES(?,?,?,?)");
                            $sql->execute([NULL, $data['mail'], $data['username'], $password]);
                       // if($data['keepSigned']==='keep'){
                            //setcookie('username', $data['mail'],strtotime( '+30 days' ) ,'/');
                            //$_SESSION['user'] = $data['mail'];
                       // }
                      //  else if($data['keepSigned']==='no'){
                            //setcookie('username', $data['mail'],strtotime( '+1 day' ) ,'/');
                            $_SESSION['user'] = $data['username'];
                      //  }
                        
                      $this->answer['answer']= $$lang['okMsg'];
                      return json_encode($this->answer);
                    }
                }

            }

        }

        public function signIn($data, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            $data['mail']=trim($data['mail']);
            $data['password']=trim($data['password']);

            if($data['mail']==""){
                $this->answer['answer']= $$lang['errorRegEmptyMail'];
                return json_encode($this->answer);
            }

            else if($data['password']==""){
                $this->answer['answer']= $$lang['errorRegEmptyPass'];
                return json_encode($this->answer);
            }

            else{
                $sql = parent::connection()->prepare("SELECT * FROM `users` WHERE `mail` =?");
                $sql->execute([$data['mail']]);
                $result = $sql->fetch();
                if($result!=NULL){
                    if(password_verify($data['password'], $result->password)==1){
                    
                       // if($data['keepSigned']==='keep'){
                            //setcookie('username', $data['mail'],strtotime( '+30 days' ) ,'/');
                            //$_SESSION['user'] = $data['mail'];
                       // }
                      //  else if($data['keepSigned']==='no'){
                            //setcookie('username', $data['mail'],strtotime( '+1 day' ) ,'/');
                            $_SESSION['user'] = $result->username;
                       // }
                       $this->answer['answer']= $$lang['okMsg'];
                       return json_encode($this->answer);
                    }
                    else{
                        $this->answer['answer']= $$lang['errorSignIn'];
                        return json_encode($this->answer);
                    }
                }
                else{
                    $this->answer['answer']= $$lang['errorSignIn'];
                    return json_encode($this->answer);
                }
            }
        }

        public function signOut(){
            if(isset($_SESSION['user'])){
                //setcookie('username', 'a', 1, '/');
                session_start();
                unset($_SESSION['user']); // или $_SESSION = array() для очистки всех данных сессии
                session_destroy();
                header("Location: http://localhost/System_of_electronic_document_circulation/index.php");
            }
        }

        public function change_password($data){//ADD LANGUAGE MSGS

            $data['oldPass'] = trim($data['oldPass']);
            $data['newPass'] = trim($data['newPass']);

            if($data['oldPass']=="" || $data['newPass']==""){
                    
                $this->answer['answer']= "password field can't be empty";
                return json_encode($this->answer);

            }

            $sql = parent::connection()->prepare("SELECT `password` FROM `users` WHERE `username` =?");
            $sql->execute([$data['user']]);

            $result = $sql->fetch();
            if($result!=false){
                if(password_verify($data['oldPass'], $result->password)==1){
                    $newPass = password_hash($data['newPass'], PASSWORD_DEFAULT);

                    $newPassSql = parent::connection()->prepare("UPDATE `users` SET `password` =? WHERE `mail` =?");
                    $newPassSql->execute([$newPass, $data['user']]);

                    $this->answer['answer']= "password was changed";
                    return json_encode($this->answer);
                }
                else{
                    $this->answer['answer']= "incorect old password";
                    return json_encode($this->answer);
                }
            }
            else{
                $this->answer['answer']= "something went wrong";
                return json_encode($this->answer);
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

        public function historyList($user, $lang){//тут короче переделать в массив вместо строки возврат и в джейсон его и еще возвращать инфу кто сейчас должен подписать
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            //$answer = array();
            if(!empty($user)){

                //$sqlMail = parent::connection()->prepare("SELECT `mail` FROM `users` WHERE `username`=?");
                //$sqlMail->execute([$user]);
                //$mail= $sqlMail->fetch();

                $sql= parent::connection()->prepare("SELECT * FROM `docs` WHERE `sender`=?");
                $sql->execute([$user]);
                $result=$sql->fetchAll(PDO::FETCH_ASSOC);
                if($result!=NULL){
                    for($i=0; $i<count($result); $i++){
                        if($result[$i]['status']=="unchecked"){
                            array_push($this->answer, ["value"=>basename($result[$i]['document_name']), "status"=>"unchecked"]);//CAN DELETE DOC
                        }
                        else if($result[$i]['status']=="unsigned"){

                            if($result[$i]["already_signed"]!=NULL){
                                $arr = trim(str_replace($result[$i]["already_signed"],"",$result[$i]["reciever"]));
                                $arr = explode(',',$arr);
                                array_push($this->answer, ["value"=>basename($result[$i]['document_name']), "status"=>"unsigned", "current"=>$arr[1]]);
                            }
                            else{
                                $arr = explode(',',$result[$i]['reciever']);
                                array_push($this->answer, ["value"=>basename($result[$i]['document_name']), "status"=>"unsigned", "current"=>$arr[0]]);
                            }

                        }
                        else if($result[$i]['status']!="unchecked" && $result[$i]['status']!="checked" && $result[$i]['status']!="signed"){
                            array_push($this->answer, ["value"=>basename($result[$i]['document_name']), "status"=>"Deleted by admins"]);
                        }
                    }
                    
                    //return json_encode($this->answer);
                    return $this->answer;
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

                $sqlMail = parent::connection()->prepare("SELECT `mail` FROM `users` WHERE `username`=?");
                $sqlMail->execute([$user]);
                $mail= $sqlMail->fetch();
                
                $sql= parent::connection()->prepare("SELECT `document_name` FROM `docs` WHERE `status`=? AND `sender`=?");
                $sql->execute(['signed',$user]);
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

        /*public function signList($user, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            $answer='';

            $sqlMail = parent::connection()->prepare("SELECT `mail` FROM `users` WHERE `username`=?");
            $sqlMail->execute([$user]);
            $mail= $sqlMail->fetch();

            $sql= parent::connection()->prepare("SELECT `username` FROM `users` WHERE `mail`=?");
            $sql->execute([$mail->mail]);

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
        }*/

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


       /* public function sign_document($docName, $lang){
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
        }*/


        public function deleteDocument($data, $lang){

            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

           // $sqlMail = parent::connection()->prepare("SELECT `mail` FROM `users` WHERE `username`=?");
           // $sqlMail->execute([$data['user']]);
           // $mail= $sqlMail->fetchAll();
            $path='E:/xampp/htdocs/System_of_electronic_document_circulation/';
            $sql= parent::connection()->prepare("SELECT * FROM `docs` WHERE `document_name`=? AND `sender`=?");
            $sql->execute([$path.$data['docName'], $data['user']]);
            $result = $sql->fetch();
            if($result==NULL){
                return $$lang['deleteDocError1'];
            }

            else{
                if(file_exists($path.$data['docName'])){
                    unlink($path.$data['docName']); 
                    $del=parent::connection()->prepare("DELETE FROM `docs` WHERE `document_name`=? AND `sender`=?");
                    $del->execute([$path.$data['docName'], $data['user']]);
                    return $$lang['deleteDocMsg'];
                }
                else{
                    return $$lang['deleteDocError2'];
                }

            
            }

        
        } 

    }

?>