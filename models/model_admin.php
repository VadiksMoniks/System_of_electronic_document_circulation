<?php
session_start();
    class Model_Admin extends Model{

        public function signIn($data)//authorization
        {

            $data['username'] = trim($data['username']);
            $data['password'] = trim($data['password']);

            if($data['username']===''){
                return 'empty username-fiels';
            }

            if($data['password']===''){
                return 'empty password-fiels';
            }

            $usernameValid = parent::connection()->prepare("SELECT * FROM `admins` WHERE `admin` = ?");
            $usernameValid->execute([$data['username']]);

            $result = $usernameValid->fetch();

            if($result===NULL){
                return 'wrong username or password';
            }

            if(!password_verify($data['password'], $result->password)){
                return 'wrong username or password';
            }

            $_SESSION['admin'] = $data['username'];
            return 'ok';

        }

        public function signOut()
        {
            if(isset($_SESSION['admin'])){
                //setcookie('username', 'a', 1, '/');
                session_start();
                unset($_SESSION['admin']); // или $_SESSION = array() для очистки всех данных сессии
                session_destroy();
                header("Location: http://localhost/System_of_electronic_document_circulation/index.php");
            }
        }

        public function documentList()//return list of all records
        {
            $list = '';

            $sqlData = parent::connection()->prepare("SELECT * FROM `docs` WHERE `status` = 'unchecked 'ORDER BY `id` DESC");
            $sqlData->execute();

            $resultList = $sqlData->fetchAll();
            foreach($resultList as $docInfo){
                $list.='<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='.basename($docInfo->document_name).'">'.basename($docInfo->document_name).'</a></br>';
            }

          //  $list.=' </table>';
            return $list;

        }

        public function numOfRecords()//return nunber of recird to understand if there is new records NOT USING!!!!!!
        {
            $sql = parent::connection()->prepare("SELECT * FROM `docs`");
            $sql->execute();
            $num = $sql->fetchAll(PDO::FETCH_ASSOC);

            return count($num);
        }

        public function showDocument($name)//returns the img of document
        {
            $name = trim($name);

            if($name===""){
                return 'document name is empty!';
            }

            $docPathSql = parent::connection()->prepare("SELECT * FROM `docs` WHERE `document_name` = ?");
            $docPathSql->execute(['E:/xampp/htdocs/System_of_electronic_document_circulation/'.$name]);

            $docPath = $docPathSql->fetch();

            if($docPath===false){
                return 'wrong document name';
            }

            echo '<img src="http://localhost/System_of_electronic_document_circulation/'.basename($docPath->document_name).'">';
        }

        public function manipulateDocument($docName, $message)
       //delete the document from server if there is something wrong and in future return info to sender      I WROTE SOMETHING BUT DON'T KNOW IF IT WORKS NOW IT CAN ONLU DELETE FILE AND DELETE RECORD FROM DB
        //YOU CAN DELETE THE RECORD FROM DB BY REQUEST FROM AJAX WHEN HUMAN VISIT THE PAGE SEND AJAX REQUEST AFTER LOADING PAGE(DELETE RECORD) AND DON'T RELOAD PAGE(MB ADD BUTTON BY CLICKUNG ON WHICH USER'LL BE RELOCATED TO ACC)
        {   
        $message = trim($message);

            if($message===''){
                return 'Please specify the reasone of deletion of document';
            }

            if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ\s\-`]+/',$message)){
                return "Reasone of deletion must be on ukrainian language";
            }

            $checkValid = parent::connection()->prepare("SELECT * FROM `docs` WHERE `document_name` = ?");
            $checkValid->execute(["E:/xampp/htdocs/System_of_electronic_document_circulation/".$docName]);

            $result = $checkValid->fetch();

            if($result===NULL){
                return 'wrong document name';
            }

            unlink($result->document_name);
            $deleteStatement = parent::connection()->prepare("UPDATE `docs` SET `status` = ?  WHERE `document_name` = ?");
            $deleteStatement->execute([$message, "E:/xampp/htdocs/System_of_electronic_document_circulation/".$docName]);

            return "Document Was DELETED";
        }

        public function checkDocument($docName)
        {
            $checkedStatus = parent::connection()->prepare("UPDATE `docs` SET `status` = ? WHERE `document_name` = ?");
            $checkedStatus->execute(["unsigned","E:/xampp/htdocs/System_of_electronic_document_circulation/".$docName]);

            return 'Thank You!';
        }

        //SORTIROVKI
        public function sortByDocName($docName)
        { 
            $list = '';
            $data = array();
            if($docName!="Select document name"){
                $docName= str_replace(" ", "_", $docName);
               

                $sqlData = parent::connection()->prepare("SELECT * FROM `docs` WHERE `status` = 'unchecked' AND `document_name` LIKE ? ORDER BY `id` DESC");
                $sqlData->execute(["%$docName%"]);

                $resultList = $sqlData->fetchAll();
                foreach($resultList as $docInfo){
                   // array_push($data,[])
                    $list.='<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='.basename($docInfo->document_name).'">'.basename($docInfo->document_name).'</a></br>';
                }

            //  $list.=' </table>';
                return $list;
            }
            else{

                $sqlData = parent::connection()->prepare("SELECT * FROM `docs` WHERE `status` = 'unchecked 'ORDER BY `id` DESC");
                $sqlData->execute();
    
                $resultList = $sqlData->fetchAll();
                foreach($resultList as $docInfo){
                    $list.='<a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='.basename($docInfo->document_name).'">'.basename($docInfo->document_name).'</a></br>';
                }
    
              //  $list.=' </table>';
                return $list;

            }
        }

     /*   public function makePost($data)
        {   
           // var_dump($_FILES);
            $path='E:/xampp/htdocs/System_of_electronic_document_circulation/articles/';
            if(trim($data['name'])===""){
                return "please add article name";
            }
            if(empty($_FILES['text']['name'])){
                return "please add article text";
            }

            $filetype = new SplFileInfo($_FILES['text']['name']);
            if($filetype->getExtension() != 'txt'){
                return "article must be a txt file";
            }

            $filePath1=$path.basename($_FILES['text']['name']);
            move_uploaded_file($_FILES['text']['tmp_name'], $filePath1);

            if(count($_FILES)<2){
                $sql = parent::connection()->prepare("INSERT INTO `articles` VALUES(NULL, ?, ?, NULL, ?)");
                $sql->execute([$data['name'], $filePath1,date('d-m-Y')]);
                return "post was created";
            }
            else{
                $filetype = new SplFileInfo($_FILES['image']['name']);
            
                if($filetype->getExtension() != 'png'){
                    return "image must be offtype png";
                }
                
                $filePath2=$path.basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $filePath2);

                $sql = parent::connection()->prepare("INSERT INTO `articles` VALUES(NULL, ?, ?, ?, ?)");
                $sql->execute([$data['name'], $filePath1,$filePath2,date('d-m-Y')]);
                return "post was created";
            }
        }

        public function articles_list()
        {
            $list='';
            $sqlData = parent::connection()->prepare("SELECT * FROM `articles` ORDER BY `id` DESC");
            $sqlData->execute();

            $resultList = $sqlData->fetchAll();
            if(!$resultList){
                return '0 articles exists';
            }
            foreach($resultList as $postInfo){
               //ТУТ МОЖНА ССИЛКУ НА ПОСТ И НАЗВАНИЕ ПОСТА 
               $list.="<ahref='http://localhost/System_of_electronic_document_circulation/index.php/admin/viewPost?n='".basename($postInfo->articles_name)."'>".basename($postInfo->articles_name)."</a></br>";
            }
            return $list;
        }

        public function searchByArticlesList($name)
        {
            
        }*/

    }

?>