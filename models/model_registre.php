<?php
include_once 'E:/xampp/htdocs/System_of_electronic_document_circulation/core/model.php';

class Model_Registre extends Model{
    public function registre(){

        $target_dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/signatures/';

        if(trim($_POST['mail'])==""){
            return "'mail' field can't be empty";
        }

        else if(trim($_POST['username'])==""){
            return "'username' field can't be empty";
        }

        else if(trim($_POST['password'])==""){
            return "'password' field can't be empty";
        }

        else if(trim($_POST['status'])==""){
            return "chose Your status";
        }

        else if(trim($_FILES['filename']['name'])==""){
            return "add your's signature scan-copy";
        }

        /*else if(!isset($_POST['seal'])){
            return "add your's seal scan-copy";
        }
*/
        else{

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            /*checking seal and signature
                
            */$signature = $target_dir.$_FILES['filename']['name'];
            $seal = null;

            $sql = parent::connection()->prepare("SELECT * FROM `users` WHERE `username` =?");
            $sql->execute([$_POST['username']]);
            $result = $sql->fetch();
            if($result!=null){
                return "Such username is allready using";//checking username's unicity
            }
            else{
                $sql->execute([$_POST['mail']]);
                $result = $sql->fetch();
                if($result!=null){
                    return "Such e-mail address is allready using";//checking mail unicity
                }
                else{
                   // if(!isset($seal)){
                        $sql = parent::connection()->prepare("INSERT INTO `users` VALUES(?,?,?,?,?,?,?)");
                        $sql->execute([NULL, $_POST['mail'], $_POST['username'], $password, $_POST['status'], $signature, NULL]);
                        move_uploaded_file($_FILES['filename']['tmp_name'], $target_dir);
                  //  }
                  //  else{
                   //     $sql = parent::connection()->prepare("INSERT INTO `users` VALUES(?,?,?,?,?,?,?)");
                   //     $sql->execute([NULL, $_POST['mail'], $_POST['username'], $password, $_POST['status'], $signature, NULL]);
                   // }

                    $_SESSION['user'] = $_POST['username'];
                    return "OK";
                }
            }

        }

    }
}
?>