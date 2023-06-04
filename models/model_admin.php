<?php
    namespace Models;

    session_start();

    use Core\Model;

    class Model_Admin extends \Core\Model{

        public function signIn($data, $lang='en')
        {

            $this->answer['answer'] = $this->checkEmptity($data, $lang);
            if($this->answer['answer']!=1){
                return json_encode($this->answer);
            }

            //$usernameValid = $this->pdo->prepare("SELECT * FROM `admins` WHERE `admin` = ?");
           // $usernameValid->execute([$data['username']]);

            $result = self::makeQuery('select', "SELECT * FROM `admins` WHERE `admin` = ?", $data['username'], 'fetch');//$usernameValid->fetch();

            if($result == false){
                $this->answer['answer']= 'wrong username or password';
                return json_encode($this->answer);
            }

            if(!password_verify($data['password'], $result->password)){
                $this->answer['answer']= 'wrong username or password';
                return json_encode($this->answer);
            }

            $_SESSION['admin'] = $data['username'];
            $this->answer['answer']= 'ok';
            return json_encode($this->answer);

        }

        public function documentList()//return list of all records
        {
            //$list = array();

            //$sqlData = $this->pdo->prepare("SELECT * FROM `docs` WHERE `status` = 'unchecked 'ORDER BY `id` DESC");
            //$sqlData->execute();

            $resultList = self::makeQuery('select', "SELECT * FROM `docs` WHERE `status` = 'unchecked 'ORDER BY `id` DESC", null, 'fetchAll');//$sqlData->fetchAll();
            $this->answer['path'] =[];
            $this->answer['status']=[];
            $this->answer['sender']=[];
            foreach($resultList as $docInfo){
                array_push($this->answer['path'],basename($docInfo->document_name));
                array_push($this->answer['status'], $docInfo->status);
                    array_push($this->answer['sender'], $docInfo->sender);
            }

          //  $list.=' </table>';
            return $list;

        }

       /* public function numOfRecords()//return nunber of recird to understand if there is new records NOT USING!!!!!!
        {
            $sql = parent::connection()->prepare("SELECT * FROM `docs`");
            $sql->execute();
            $num = $sql->fetchAll(PDO::FETCH_ASSOC);

            return count($num);
        }*/

        public function showDocument($name)//returns the img of document
        {
            $name = trim($name);

            if($name===""){
                return 'document name is empty!';
            }

            //$docPathSql = $this->pdo->prepare("SELECT * FROM `docs` WHERE `document_name` = ?");
            //$docPathSql->execute(['E:/xampp/htdocs/System_of_electronic_document_circulation/'.$name]);

            $docPath = self::makeQuery('select', "SELECT * FROM `docs` WHERE `document_name` = ?", ['E:/xampp/htdocs/System_of_electronic_document_circulation/'.$name], 'fetch');//$docPathSql->fetch();

            if($docPath===false){
                return 'wrong document name';
            }

            $this->answer['path']=basename($docPath->document_name);
            $this->answer['status']=$docPath->status;
            return $this->answer;
        }

        public function manipulateDocument($docName, $message)
       //delete the document from server if there is something wrong and in future return info to sender
        //YOU CAN DELETE THE RECORD FROM DB BY REQUEST FROM AJAX WHEN HUMAN VISIT THE PAGE SEND AJAX REQUEST AFTER LOADING PAGE(DELETE RECORD) AND DON'T RELOAD PAGE(MB ADD BUTTON BY CLICKUNG ON WHICH USER'LL BE RELOCATED TO ACC)
        {   
            $message = trim($message);

            if($message===''){
                $this->answer['answer'] = 'Please specify the reasone of deletion of document';
            }

            if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ\s\-`]+/',$message)){
                $this->answer['answer'] = "Reasone of deletion must be on ukrainian language";
            }

            //$checkValid = $this->pdo->prepare("SELECT * FROM `docs` WHERE `document_name` = ?");
            //$checkValid->execute(["E:/xampp/htdocs/System_of_electronic_document_circulation/".$docName]);

            $result = self::makeQuery('select', "SELECT * FROM `docs` WHERE `document_name` = ?", ["E:/xampp/htdocs/System_of_electronic_document_circulation/".$docName], 'fetch');//$checkValid->fetch();

            if($result===NULL){
                $this->answer['answer'] = 'wrong document name';
            }

            unlink($result->document_name);
            //$deleteStatement = $this->pdo->prepare("UPDATE `docs` SET `status` = ?  WHERE `document_name` = ?");
            //$deleteStatement->execute([$message, "E:/xampp/htdocs/System_of_electronic_document_circulation/".$docName]);
            $result = self::makeQuery('update', "UPDATE `docs` SET `status` = ?  WHERE `document_name` = ?", [$message, "E:/xampp/htdocs/System_of_electronic_document_circulation/".$docName]);
            if($result==0){
                $this->answer['answer'] = "Document Was DELETED";
                return json_encode($this->answer);
            }
            

            
        }

        public function checkDocument($docName)
        {
            //$checkedStatus = $this->pdo->prepare("UPDATE `docs` SET `status` = ? WHERE `document_name` = ?");
            //$checkedStatus->execute(["unsigned","E:/xampp/htdocs/System_of_electronic_document_circulation/".$docName]);

            $result = self::makeQuery('update', "UPDATE `docs` SET `status` = ? WHERE `document_name` = ?", ["unsigned","E:/xampp/htdocs/System_of_electronic_document_circulation/".$docName]);
            if($result==0){
                $this->answer['answer'] = 'Thank You!';
                return json_encode($this->answer);
            }
        }

        //SORTIROVKI
        public function sort($data)
        { 
            $this->answer['path'] =[];
            $this->answer['status']=[];
            $this->answer['sender']=[];
            
            $status = $data['status'];
            $type = str_replace(" ", "_", $data['type']);
            $data['name'] = trim($data['name']);
            if(!empty($data['name'])){
                $name = $data['name'];
            }
            //var_dump($data);
            if(isset($name)){
                if($type=="Select_document_name"){
                    $sqlData = $this->pdo->prepare("SELECT * FROM `docs` WHERE `status` = ? AND `sender` LIKE ? ORDER BY `id` DESC");
                    $sqlData->execute([$status, "%$name%"]);
                }
                else{
                    $sqlData = $this->pdo->prepare("SELECT * FROM `docs` WHERE `status` = ? AND `sender` LIKE ? AND `document_name` LIKE ? ORDER BY `id` DESC");
                     $sqlData->execute([$status, "%$name%", "%$type%"]);
                }
            }
            else{
                if($type=="Select_document_name"){
                    $sqlData = $this->pdo->prepare("SELECT * FROM `docs` WHERE `status` = ? ORDER BY `id` DESC");
                    $sqlData->execute([$status]);
                }
                else{
                    $sqlData = $this->pdo->prepare("SELECT * FROM `docs` WHERE `status` = ? AND `document_name` LIKE ? ORDER BY `id` DESC");
                    $sqlData->execute([$status,"%$type%"]);
                }
            }
            $resultList = $sqlData->fetchAll();
                foreach($resultList as $docInfo){
                   // array_push($data,[])
                    //$list.='<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='.basename($docInfo->document_name).'">'.basename($docInfo->document_name).'</a></br>';
                    array_push($this->answer['path'], basename($docInfo->document_name));
                    array_push($this->answer['status'], $docInfo->status);
                    array_push($this->answer['sender'], $docInfo->sender);
                }
            
            return json_encode($this->answer);
        }

    }
