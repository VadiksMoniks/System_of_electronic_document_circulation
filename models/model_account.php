<?php
    namespace Models;
    session_start();

    use Core\Model;

    class Model_Account extends \Core\Model
    {

        public function registre($data, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            $this->answer['answer'] = $this->checkEmptity($data, $lang);
            if($this->answer['answer']!=1){
                return json_encode($this->answer);
            }

            $this->answer['answer'] = $this->validateMail($data['mail'], $lang);
            if($this->answer['answer']!=1){
                return json_encode($this->answer);
            }

                $password = password_hash($data['password'], PASSWORD_DEFAULT);

                $result = self::makeQuery('select',"SELECT * FROM `users` WHERE `username` =?", $data['username'],'fetch');
                //return var_dump($data);
                if($result!=false){
                    $this->answer['answer']= self::returnMessage('errorRegununiqName',$$lang);//checking username's unicity
                    return json_encode($this->answer);
                }
                else{

                        $result = self::makeQuery('select', "SELECT * FROM `users` WHERE `mail` =?", $data['mail'],'fetch');
                   // return var_dump($data);
                    if($result!=false){
                        $this->answer['answer']= self::returnMessage('errorRegununiqMail',$$lang);//checking mail unicity
                        return json_encode($this->answer);
                    }
                    else{
                            $token = md5(time());

                            self::makeQury('insert', "INSERT INTO `waiting_for_auth` VALUES(?,?,?,?,?)", [NULL, $data['mail'], $data['username'], $password, $token]);

                            $header = 'Verification Mail';
                            $message = 'This is No-reply letter. Please follow this link to end your registration on our web-site. <a href=http://localhost/System_of_electronic_document_circulation/index.php/account/registre?token='.$token.'>http://localhost/System_of_electronic_document_circulation/index.php/account/registre?token='.$token.'</a></br>';
                            $this->sendMail($data['mail'], $header, $message);
                        
                            $this->answer['answer']= self::returnMessage('checkMail', $$lang);//$$lang['okMsg'];
                            return json_encode($this->answer);
                    }
               // }

            }

        }

        public function verificate($token, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            if(isset($token) && !empty($token)){

                $userData =self::makeQuery('select', "SELECT * FROM `waiting_for_auth` WHERE `token` = ?", $token,'fetch');

                if($userData == false){
                    $this->answer['answer'] = 'wrong URL';
                    return json_encode($this->answer);
                }
                else{

                    self::makeQury('insert', "INSERT INTO `users` VALUES(?,?,?,?,?)", [NULL, $userData->mail, $userData->username, $userData->password, 1]);

                    self::makeQuery('delete', "DELETE FROM `waiting_for_auth` WHERE `token` =?", $token);
                    $_SESSION['user'] = $userData->username;

                    $this->answer['answer'] = self::returnMessage('okMsg', $$lang);
                    return json_encode($this->answer);
                }
            }
        }

        public function signIn($data, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            $this->answer['answer'] = $this->checkEmptity($data, $lang);
            if($this->answer['answer']!=1){
                return json_encode($this->answer);
            }
                $result = self::makeQuery('select', "SELECT * FROM `users` WHERE `mail` =?", $data['mail'],'fetch');//$sql->fetch();

                if($result!=false){
                    if(password_verify($data['password'], $result->password)==1){

                        $_SESSION['user'] = $result->username;
                       
                        $this->answer['answer']= self::returnMessage('okMsg',$$lang);
                        return json_encode($this->answer);
                    }
                    else{
                        $this->answer['answer']= self::returnMessage('errorSignIn', $$lang);
                        return json_encode($this->answer);
                    }
                }
                else{
                    $this->answer['answer']= self::returnMessage('errorSignIn', $$lang);
                    return json_encode($this->answer);
                }
            
        }

        public function change_password($data){//ADD LANGUAGE MSGS

            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            $this->answer['answer'] = $this->checkEmptity($data, 'en');
            if($this->answer['answer']!=1){
                return json_encode($this->answer);
            }

            $result = self::makeQuery('select', "SELECT `password` FROM `users` WHERE `username` =?", $data['user'],'fetch');
            if($result!=false){
                if(password_verify($data['oldPass'], $result->password)==1){
                    $newPass = password_hash($data['newPass'], PASSWORD_DEFAULT);

                    self::makeQuery('update', "UPDATE `users` SET `password` =? WHERE `mail` =?", [$newPass, $data['user']]);

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

                $result= self::makeQuery('select', "SELECT * FROM `docs` WHERE `sender`=? AND `status` !='signed'", $user,'fetchAll', \PDO::FETCH_ASSOC);
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
                    return self::returnMessage('Msghistory', $$lang);
                }
            }
        
            return "Wrong user data";
        }

        public function dwnlist($user, $lang){
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            if(!empty($user)){

                $result = self::makeQuery('select', "SELECT `document_name` FROM `docs` WHERE `status`=? AND `sender`=?", ['signed',$user], 'fetchAll', \PDO::FETCH_ASSOC);
                if($result!=false){
                    for($i=0; $i<count($result); $i++){
                        array_push($this->answer, basename($result[$i]['document_name']));
                    }
                    return $this->answer;
                }
                else{
                    return self::returnMessage('Msgdwn', $$lang);
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

                $msg = self::makeQuery('select', "SELECT `status` FROM `docs` WHERE `document_name` = ?", ['E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName],'fetch');
                if(!$msg){
                     return self::returnMessage('show_docError', $$lang);
                }
                
                else{
                    if($msg->status!='unsigned' && $msg->status!='signed'){


                        self::makeQuery('delete', "DELETE FROM `docs` WHERE `document_name` = ?", 'E:/xampp/htdocs/System_of_electronic_document_circulation/'.$docName);

                        return $this->answer['answet']=$msg->status;
                    }
                   
                }
               
            }
        }


        public function deleteDocument($data, $lang){

            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

            $path='E:/xampp/htdocs/System_of_electronic_document_circulation/';

            $result = self::makeQuery('select', "SELECT * FROM `docs` WHERE `document_name`=? AND `sender`=?", [$path.$data['docName'], $data['user']],'fetch');
            if($result===false){
                return self::returnMessage('deleteDocError1', $$lang);
            }

            else{
                if(file_exists($path.$data['docName'])){
                    unlink($path.$data['docName']); 

                    self::makeQuery('delete', "DELETE FROM `docs` WHERE `document_name`=? AND `sender`=?", [$path.$data['docName'], $data['user']]);

                    return self::returnMessage('deleteDocMsg', $$lang);
                }
                else{
                    return self::returnMessage('deleteDocError2', $$lang);
                }

            
            }

        
        } 

        public function notificationStatus($user){

            $result = self::makeQuery('select', "SELECT `notification` FROM `users` WHERE `username` = ?", $user['user'],'fetch');
            if($result != false){
                return $result->notification;
            }
        }

        public function turnNotification($user){
            $value=0;

            $result = self::makeQuery('select', "SELECT `notification` FROM `users` WHERE `username` = ?", $user['user'],'fetch');
            if($result != false){
                if($result->notification == 1){
                    $this->answer['answer']= 'Now you`ll not get notifications on You`r e-mail address. You can change this setting at any time';
                }
                else{
                    $value = 1;
                    $this->answer['answer']= 'Now you`ll get notifications on You`r e-mail address. You can change this setting at any time';
                }

                self::makeQuery('update', "UPDATE `users` SET `notification` = ? WHERE `username` = ?", [$value, $user['user']]);

                return $this->answer['answer'];
            }
        }

    }
