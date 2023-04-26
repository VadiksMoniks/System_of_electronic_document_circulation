<?php
session_start();

    class Model_Account extends Model
    {

        public function registre($data, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            $this->answer['answer'] = self::checkEmptity($data, $lang);
            if($this->answer['answer']!=1){
                return json_encode($this->answer);
            }

            $this->answer['answer'] = self::validateMail($data['mail'], $lang);
            if($this->answer['answer']!=1){
                return json_encode($this->answer);
            }

                $password = password_hash($data['password'], PASSWORD_DEFAULT);

                $sql = $this->pdo->prepare("SELECT * FROM `users` WHERE `username` =?");
                $sql->execute([$data['username']]);
                $result = $sql->fetch();
                //return var_dump($data);
                if($result!=false){
                    $this->answer['answer']= $$lang['errorRegununiqName'];//checking username's unicity
                    return json_encode($this->answer);
                }
                else{
                    $sql = $this->pdo->prepare("SELECT * FROM `users` WHERE `mail` =?");
                    $sql->execute([$data['mail']]);
                    $result = $sql->fetch();
                   // return var_dump($data);
                    if($result!=false){
                        $this->answer['answer']= $$lang['errorRegununiqMail'];//checking mail unicity
                        return json_encode($this->answer);
                    }
                    else{
                            $token = md5(time());
                            $sql = $this->pdo->prepare("INSERT INTO `waiting_for_auth` VALUES(?,?,?,?,?)");
                            $sql->execute([NULL, $data['mail'], $data['username'], $password, $token]);

                            $header = 'Verification Mail';
                            $message = 'This is No-reply letter. Please follow this link to end your registration on our web-site. <a href=http://localhost/System_of_electronic_document_circulation/index.php/account/registre?token='.$token.'>http://localhost/System_of_electronic_document_circulation/index.php/account/registre?token='.$token.'</a></br>';
                            self::sendMail($data['mail'], $header, $message);
                        
                            $this->answer['answer']= $$lang['checkMail'];//$$lang['okMsg'];
                            return json_encode($this->answer);
                    }
               // }

            }

        }

        public function verificate($token, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            if(isset($token) && !empty($token)){
                $sql = $this->pdo->prepare("SELECT * FROM `waiting_for_auth` WHERE `token` = ?");
                $sql->execute([$token]);

                $userData = $sql->fetch();

                if($userData == false){
                    $this->answer['answer'] = 'wrong URL';
                    return json_encode($this->answer);
                }
                else{
                    $addUser = $this->pdo->prepare("INSERT INTO `users` VALUES(?,?,?,?,?)");
                    $addUser->execute([NULL, $userData->mail, $userData->username, $userData->password, 1]);
                    $dropData = $this->pdo->prepare("DELETE FROM `waiting_for_auth` WHERE `token` =?");
                    $dropData->execute([$token]);
                    $_SESSION['user'] = $userData->username;

                    $this->answer['answer'] = $$lang['okMsg'];
                    return json_encode($this->answer);
                }
            }
        }

        public function signIn($data, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            $this->answer['answer'] = self::checkEmptity($data, $lang);
            if($this->answer['answer']!=1){
                return json_encode($this->answer);
            }

                $sql = $this->pdo->prepare("SELECT * FROM `users` WHERE `mail` =?");
                $sql->execute([$data['mail']]);
                $result = $sql->fetch();
                if($result!=false){
                    if(password_verify($data['password'], $result->password)==1){

                        $_SESSION['user'] = $result->username;
                       
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

        public function change_password($data){//ADD LANGUAGE MSGS

            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            $this->answer['answer'] = self::checkEmptity($data, 'en');
            if($this->answer['answer']!=1){
                return json_encode($this->answer);
            }

            $sql = $this->pdo->prepare("SELECT `password` FROM `users` WHERE `username` =?");
            $sql->execute([$data['user']]);

            $result = $sql->fetch();
            if($result!=false){
                if(password_verify($data['oldPass'], $result->password)==1){
                    $newPass = password_hash($data['newPass'], PASSWORD_DEFAULT);

                    $newPassSql = $this->pdo->prepare("UPDATE `users` SET `password` =? WHERE `mail` =?");
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

        public function historyList($user, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            //$answer = array();
            if(!empty($user)){

                //$sqlMail = parent::connection()->prepare("SELECT `mail` FROM `users` WHERE `username`=?");
                //$sqlMail->execute([$user]);
                //$mail= $sqlMail->fetch();

                $sql= $this->pdo->prepare("SELECT * FROM `docs` WHERE `sender`=?");
                $sql->execute([$user]);
                $result=$sql->fetchAll(PDO::FETCH_ASSOC);
                if($result!=false){
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

            if(!empty($user)){
                $sql= $this->pdo->prepare("SELECT `document_name` FROM `docs` WHERE `status`=? AND `sender`=?");
                $sql->execute(['signed',$user]);
                $result=$sql->fetchAll(PDO::FETCH_ASSOC);
                if($result!=false){
                    for($i=0; $i<count($result); $i++){
                        array_push($this->answer, basename($result[$i]['document_name']));
                    }
                    return $this->answer;
                }
                else{
                    return $$lang['Msgdwn'];
                }
            }
        
            return "Wrong user data";
            
        }

        public function show_doc($docName, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            if(file_exists('E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName)){
                return '<img src="http://localhost/System_of_electronic_document_circulation/'.$docName.'">';
            }
            else{
               // return $$lang['show_docError'];
                $msgSQL = $this->pdo->prepare("SELECT `status` FROM `docs` WHERE `document_name` = ?");
                $msgSQL->execute(['E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName]);
                $msg = $msgSQL->fetch();
                if(!$msg){
                     return $$lang['show_docError'];
                }
                
                else{
                    if($msg->status!='unsigned' && $msg->status!='signed'){

                        $deleteRecord = $this->pdo->prepare("DELETE FROM `docs` WHERE `document_name` = ?");
                        $deleteRecord->execute(['E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName]);

                        return $this->answer['answet']=$msg->status;
                    }
                   
                }
               
            }
        }


        public function deleteDocument($data, $lang){

            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

           // $sqlMail = parent::connection()->prepare("SELECT `mail` FROM `users` WHERE `username`=?");
           // $sqlMail->execute([$data['user']]);
           // $mail= $sqlMail->fetchAll();
            $path='E:/xampp/htdocs/System_of_electronic_document_circulation/';
            $sql= $this->pdo->prepare("SELECT * FROM `docs` WHERE `document_name`=? AND `sender`=?");
            $sql->execute([$path.$data['docName'], $data['user']]);
            $result = $sql->fetch();
            if($result===false){
                return $$lang['deleteDocError1'];
            }

            else{
                if(file_exists($path.$data['docName'])){
                    unlink($path.$data['docName']); 
                    $del=$this->pdo->prepare("DELETE FROM `docs` WHERE `document_name`=? AND `sender`=?");
                    $del->execute([$path.$data['docName'], $data['user']]);
                    return $$lang['deleteDocMsg'];
                }
                else{
                    return $$lang['deleteDocError2'];
                }

            
            }

        
        } 

        public function notificationStatus($user){
            $sql = $this->pdo->prepare("SELECT `notification` FROM `users` WHERE `username` = ?");
            $sql->execute([$user['user']]);
            $result = $sql->fetch();
            if($result != false){
                return $result->notification;
            }
        }

        public function turnNotification($user){
            $value=0;
            $sql = $this->pdo->prepare("SELECT `notification` FROM `users` WHERE `username` = ?");
            $sql->execute([$user['user']]);
            $result = $sql->fetch();
            if($result != false){
                if($result->notification == 1){
                    $this->answer['answer']= 'Now you`ll not get notifications on You`r e-mail address. You can change this setting at any time';
                }
                else{
                    $value = 1;
                    $this->answer['answer']= 'Now you`ll get notifications on You`r e-mail address. You can change this setting at any time';
                }

                $sql = $this->pdo->prepare("UPDATE `users` SET `notification` = ? WHERE `username` = ?");
                $sql ->execute([$value, $user['user']]);
                return $this->answer['answer'];
            }
        }

    }

?>