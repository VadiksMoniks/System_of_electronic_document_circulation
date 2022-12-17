<?php

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

            setcookie('root', 'admin',strtotime( '+30 days' ) ,'/');
            return 'ok';

        }

        public function signOut()//signOut from site go to form
        {
            if(isset($_COOKIE['root'])){
                setcookie('root', '0', 1 ,'/');
                header("Location: http://localhost/System_of_electronic_document_circulation/index.php/admin/authorization");
            }
        }

        public function documentList()//return list of all records
        {
            $list = '<table id="list">
                        <tr> 
                            <th>sender</th>
                            <th>reciever</th>   
                            <th>document</th>
                        </tr>';
            /*
                <tr>
                   
                    

                

           
            */
            $sqlData = parent::connection()->prepare("SELECT * FROM `docs` WHERE `status` = 'unsigned'ORDER BY `id` DESC");
            $sqlData->execute();

            $resultList = $sqlData->fetchAll();
            foreach($resultList as $docInfo){
                $list.='<tr><td>'.$docInfo->sender.'</td><td>'.$docInfo->reciever.'</td><td><a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='.basename($docInfo->document_name).'">'.$docInfo->document_name.'</a></td></tr>';
            }

            $list.=' </table>';
            return $list;

        }

        public function numOfRecords()//return nunber of recird to understand if there is new records
        {
            $sql = parent::connection()->prepare("SELECT * FROM `docs`");
            $sql->execute();
            $num = $sql->fetchAll(PDO::FETCH_ASSOC);

            return count($num);
        }

        public function showDocument($name)//returns the img of document
        {
            $name = trim($name);
            $docPathSql = parent::connection()->prepare("SELECT * FROM `docs` WHERE `document_name` = ?");
            $docPathSql->execute(['E:/xampp/htdocs/System_of_electronic_document_circulation/'.$name]);

            $docPath = $docPathSql->fetch();

            if($docPath===NULL){
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

    }

?>