<?php
    include 'languages.php';
    class Model_Documents extends Model{

<<<<<<< HEAD

        private function document_a($data, $lang, $signature){
=======
        private $answer = array();//FOR JSON ANSWER

        public function showExample($document_name){

            if(isset($document_name)){
                if(trim($document_name)!=''){
                  //  $method_name='document_'.$document_name;
                  //  if(method_exists('Model_Documents',$method_name)){
                  //      return self::$method_name();
                    return self::documentCreation($document_name);
                
                }
                else{
                        return 'wrong document name';
                }
            }
        }



        public function generateDoc($data, $lang)
        {
>>>>>>> development
            /*
                значит смотри сюда, урод. ты когда эту хуету кодил, вызывал функцию '( $userSignature = imagecreatefrompng($removeSig);)'- так вот она толбко для пнг изображений, какой сюрприз блять. короче
                нужно либо создать переменную, которая будет хранить формат и потом вызывать функцию для этого формата или так же в переменную записать формат ,
                но потом ее конкатенировать с названием метода(хз можно ли так) и нужно глянуть в мануале, какие функции есть кроmе png i jpeg
            */ 
            //
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
<<<<<<< HEAD

                //username
                $senderName=parent::connection()->prepare('SELECT `username` FROM `users` WHERE `mail`=?');
                $senderName->execute([$_COOKIE['username']]);
                $sName= $senderName->fetch();

                //

                $example = imagecreatefrompng('http://localhost/System_of_electronic_document_circulation/document_examples/canvas.png');
                $userSignature = imagecreatefrompng($signature);
                $file = 'http://localhost/System_of_electronic_document_circulation/document_examples/'.$data['name'].'.txt';
                // $handle = fopen($filename, "r");
                $filetext = mb_convert_encoding(file_get_contents($file), 'UTF-8');
                $filetext=preg_replace('/ПІБ/', $data['initials'], $filetext);
                $filetext=preg_replace('/ГРУПА/', $data['group'], $filetext);
                $filetext=preg_replace('/КОГО/', $data['recipient'], $filetext);
                $filetext=preg_replace('/ я великий молодець і зробив цю курсову/', $data['text'], $filetext);
                $textarr = explode(';',$filetext);
                //fclose($handle);


                imagettftext($example, 15, 0, 450, 100, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[0]);
                imagettftext($example, 15, 0, 450, 140, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[1]);
                imagettftext($example, 15, 0, 350, 180, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[2]);
                imagettftext($example, 15, 0, 450, 240, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[3]);
                imagettftext($example, 15, 0, 380, 350, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[4]);
                imagettftext($example, 15, 0, 150, 400, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[5]);

                $text = str_split($textarr[6], 100);
                $x=150;
                $y=420;
                for($i=0; $i<count($text); $i++){
                    if($i===0){
                        imagettftext($example, 15, 0, $x, $y, imagecolorallocate($example,0,0,0), 'arial.ttf', $text[$i]);
                    }
                    else{
                        imagettftext($example, 15, 0, $x, $y+($i*20), imagecolorallocate($example,0,0,0), 'arial.ttf', $text[$i]);
                    }
                    
                }
               // 
                imagettftext($example, 15, 0, 200, 800, imagecolorallocate($example,0,0,0), 'arial.ttf', date('d m Y'));
                imagettftext($example, 15, 0, 200, 850, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[7]);
                imagettftext($example, 15, 0, 300, 800, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[8]);
                imagettftext($example, 15, 0, 650, 850, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[9]);
                imagettftext($example, 15, 0, 550, 1100, imagecolorallocate($example,0,0,0), 'arial.ttf', $textarr[10]);
                imagecopy($example, $userSignature, 600, 700, 0, 0 ,126, 100);
                $picName=$sName->username.'_'.date("Ymd_His");
                imagepng($example, $data['name'].'_'.$picName.'.png');
                imagedestroy($example);
                imagedestroy($userSignature);
                $fName='E:/xampp/htdocs/System_of_electronic_document_circulation/'.$data['name'].'_'.$picName.'.png';

                unlink($signature);     

                $sql = parent::connection()->prepare('INSERT INTO `docs` VALUES(?,?,?,?,?)');
                $sql->execute([NULL, $_COOKIE['username'], $data['recipient'], $fName, 'unsigned']);//MAYBE CAUSE OF USING $_COOKIE['username'] IT CANE BE BUGS CAUSE MY SERVER HAS MY COOKIES BUT REMOUTE SERVER 
                //WILL NOT HAVE 'EM
                return $$lang['docMsg'];
                //I can make a group of recievers by concationation of strings and than inserting a big one into DB
                //BUT i need to make this concationation on client side in jQuery
            
        }

        public function generateDoc($data, $lang){

            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

=======
            //var_dump($data);
>>>>>>> development
            $data['initials']=trim($data['initials']);
            $data['group']=trim($data['group']);
          //  $data['recipient']=trim($data['recipient']);
            $data['text'] = trim($data['text']);

<<<<<<< HEAD
            if($data['initials']==""){
                return $$lang['docError1'];
=======
            $slice = array_slice($data, 5, 4);

            foreach($slice as $key => $value){
                if($slice[$key]==""){
                    $this->answer['answer']= $$lang['docError1'];
                    return json_encode($this->answer);
                }
>>>>>>> development
            }
           // var_dump($slice);
           
           // if($data['mail']===$data['recipient']){
           //     return $$lang['docError2'];
          //  }            
            foreach($slice as $key => $value){
                if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ\s\-`]+/',$slice[$key] )){
                    $this->answer['answer']='only ukr';
                    return json_encode($this->answer);
                }
            }

            if(preg_match('/[0-9]+/',$slice['initials'] )){
                $this->answer['answer']= "name can't contain numbers";
                return json_encode($this->answer);
            }

            if (empty($_FILES['file']['name'])){
                $this->answer['answer']= $$lang['docError4'];
                return json_encode($this->answer);
            }


           /* if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ\s\-`]+/',$data['initials'] )){
                return 'only ukr';
            }
            else if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ0-9\-]+/',$data['group'] )){
                return 'only ukr';
            }
            else if(!preg_match('/[А-Яа-яёЁЇїІіЄєҐґ0-9\/\s\-,:.`]+/',$data['text'] )){
                return 'only ukr';
            }*/


            

            $filetype = new SplFileInfo($_FILES['file']['name']);
            
            if($filetype->getExtension() != 'png'){
                $this->answer['answer']= $$lang['docError5'];
                return json_encode($this->answer);
            }

            else{
                $dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/';
                $removeSig = $dir.basename($_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $removeSig);
               
            }

           /* $recipientMailSQL = parent::connection()->prepare('SELECT * FROM `users` WHERE `mail` =?');
            $recipientMailSQL->execute([$data['recipient']]);
            $recipientMail=$recipientMailSQL->fetch();
            if($recipientMail==false){
                return $$lang['wrongRecipient'];
<<<<<<< HEAD
            }
           
            $methodName =  'document_'.$data['name'];
                if(method_exists('Model_Documents', $methodName)){
                    return self::$methodName($data, $lang, $removeSig);//WARNING!!! be carefull with required params and make something with recievers(if it'll be more than one reciever)
                }
                else{
                    return 'wrong template name';
                }
            
=======
            }*/

           // else{
              //  $method_name='document_'.$data['name'];
              //  if(method_exists($this,$method_name)){
              //      return self::$method_name($data, $lang, $removeSig);
              //  }                
           // else{
            $this->answer['answer']=self::documentCreation($data['name'], $data, $lang, $removeSig);
            return json_encode($this->answer);
           // }
   
           // }

        }

        private function documentCreation($documentName, $data=null, $lang=null, $signature=null)//LOOKS LIKE USER DOESN'T NEED TO ADD HIS SIGNATURE SIGNATURE WILL BE ADDED BY LARIN 
        {
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';


            $recipient = "username@infiz.khpi.edu.ua";
            if($data!=null && $lang!=null && $signature!=null){

                if($data['studyingForm']=='daytime'){
                    $data['studyingForm']='денної';
                }
                else{
                    $data['studyingForm']='заочної';
                }
                


                $senderName=parent::connection()->prepare('SELECT `username` FROM `users` WHERE `mail`=?');
                    $senderName->execute([$data['mail']]);
                    $sName= $senderName->fetch();

                $example = imagecreatefrompng('http://localhost/System_of_electronic_document_circulation/document_examples/canvas.png');
                $userSignature = imagecreatefrompng($signature);

                imagettftext($example, 30, 0, 1035, 209, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['course']);
                imagettftext($example, 25, 0, 1307, 209, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['group']);
                imagettftext($example, 20, 0, 825, 320, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['speciality']);
                imagettftext($example, 30, 0, 861, 375, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['studyingForm']);
                imagettftext($example, 20, 0, 805, 476, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['initials']);
                //imagettftext($example, 15, 0, 1045, 209, imagecolorallocate($example,0,0,0), 'arial.ttf', $data['course']);
                $text = str_split($data['text'], 115);
                $x=300;
                $y=683;
                for($i=0; $i<count($text); $i++){
                    if($i===0){
                        imagettftext($example, 25, 0, $x, $y, imagecolorallocate($example,0,0,0), 'arial.ttf', $text[$i]);
                    }
                    else{
                        imagettftext($example, 25, 0, $x, $y+($i*80), imagecolorallocate($example,0,0,0), 'arial.ttf', $text[$i]);
                    }
                    
                }

                imagettftext($example, 30, 0, 275, 1045, imagecolorallocate($example,0,0,0), 'arial.ttf', date('d'));
                imagettftext($example, 30, 0, 500, 1045, imagecolorallocate($example,0,0,0), 'arial.ttf', date('m'));
                imagecopy($example, $userSignature, 1329, 965, 0, 0 ,126, 100);

                $picName=$sName->username.'_'.date("Y-m-d_H-i-s");
                imagepng($example, $data['name'].'_'.$picName.'.png');
                imagedestroy($example);
                imagedestroy($userSignature);
                $fName='E:/xampp/htdocs/System_of_electronic_document_circulation/'.$data['name'].'_'.$picName.'.png';

                unlink($signature);
                
                $sql = parent::connection()->prepare('INSERT INTO `docs` VALUES(?,?,?,?,?)');
                $sql->execute([NULL, $data['mail'], $recipient, $fName, 'unchecked']);

                return $$lang['docMsg'];
            }
>>>>>>> development

            else{
                if(file_exists("E:/xampp/htdocs/System_of_electronic_document_circulation/document_examples/".$documentName."_example.png")){
                    return '<img src="http://localhost/System_of_electronic_document_circulation/document_examples/'.$documentName.'_example.png">';
                }
                else{
                    return "wrong name";
                }
            }
        }


<<<<<<< HEAD
        /*function downloadExample($docName){
            $dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/document_examples';
            $docName = $dir.$docName.'.txt';

            if(file_exists($docName)){
                //зробити пнг документу і перевести в пдф потім віддати користувачу
            }
            else{
                return "such file doesn't exists";
            }
        }*/




        public function recipientList($searchingName){//returns a list with all recipients with the similar name
=======
//////////////////////////////////////////////////////////////////////////////////////////////////!!! I CAN  MAKE ONLY ONE FUNCTION WHERE THERE WILL BE CHANGING ONLY NAMES OF DOCUMENTS 
//////////////////////////////////////////////////////////////////////////////////////////////////!!! CAUSE ALL THE REST IS THE SAME
        public function recipientList($searchingName){
>>>>>>> development
            $searchingName = trim($searchingName);
            if($searchingName!=''){
                $sql = parent::connection()->prepare('SELECT `mail` FROM `users` WHERE `mail` LIKE ?');
                $sql->execute(["%$searchingName%"]);
                $output='<ul>';
                $result = $sql->fetchAll();
                if($result!=NULL){
                    
                    foreach($result as $name){
                        $output.='<a name='.$name->mail.' class="variants"><li style="font-size:15px; font-color:#000;">'.$name->mail.'</li></a>';
                    }
                }
                else{
                    $output.= '<li style="font-size:15px;font-color:#000;">No such user</li>';
                }
                 $output.='</ul>';
                 return $output;
            }
        }

    }


?>