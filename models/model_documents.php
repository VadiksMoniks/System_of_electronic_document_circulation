<?php
    include 'languages.php';
    class Model_Documents extends Model{
//для рукописних заяв можна зробити можливіть завантажити скан
//адмін пропустить тільки скан а далі підпишуть документ отримувачі
//для цього треба окремі функції мб хз поки
       // private $answer = array();//FOR JSON ANSWER

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
            /*
                значит смотри сюда, урод. ты когда эту хуету кодил, вызывал функцию '( $userSignature = imagecreatefrompng($removeSig);)' строка 105 - так вот она толбко для пнг изображений, какой сюрприз блять. короче
                нужно либо создать переменную, которая будет хранить формат и потом вызывать функцию для этого формата или так же в переменную записать формат ,
                но потом ее конкатенировать с названием метода(хз можно ли так) и нужно глянуть в мануале, какие функции есть кропе png i jpeg
            */ 
            //
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            //var_dump($data);
            $data['initials']=trim($data['initials']);
            $data['group']=trim($data['group']);
          //  $data['recipient']=trim($data['recipient']);
            $data['text'] = trim($data['text']);

            $slice = array_slice($data, 5, 4);

            foreach($slice as $key => $value){
                if($slice[$key]==""){
                    $this->answer['answer']= $$lang['docError1'];
                    return json_encode($this->answer);
                }
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

        public function handwrittenDoc($data)
        {

            $data['name'] = trim($data['name']);
            $data['sender'] = trim($data['sender']);
            if($data['name']===""){
                return "empty username";
            }
            else if($data['sender']===""){
                return "empty document name";
            }

            $filetype = new SplFileInfo($_FILES['file']['name']);

            if($filetype->getExtension() != 'png'){
                //$this->answer['answer']= "File must be offtype PNG";
                return "File must be offtype PNG";
            }

            else{
                $dir = 'E:/xampp/htdocs/System_of_electronic_document_circulation/';
                $removeDoc = $dir.basename($_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $removeDoc);
               
            }

            //$this->answer['answer']=self::storeHandwrittenDoc($data, $removeDoc);
            //return json_encode($this->answer);
            return self::storeHandwrittenDoc($data, $removeDoc);

        }

        private function documentCreation($documentName, $data=null, $lang=null, $signature=null)//LOOKS LIKE USER DOESN'T NEED TO ADD HIS SIGNATURE SIGNATURE WILL BE ADDED BY LARIN 
        {
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';


            $recipients = "ZavKafedry@infiz.khpi.edu.ua,Larin@infiz.khpi.edu.ua,SecretaryCPC@khpi.edu.ua,ViddilKadriv@khpi.edu.ua,PROrector@khpi.edu.ua,Myguschenko@khpi.edu.ua";//array with mails
            if($data!=null && $lang!=null && $signature!=null){

                if($data['studyingForm']=='daytime'){
                    $data['studyingForm']='денної';
                }
                else{
                    $data['studyingForm']='заочної';
                }
                


                //$senderName=parent::connection()->prepare('SELECT `username` FROM `users` WHERE `mail`=?');
                //    $senderName->execute([$data['mail']]);
                //    $sName= $senderName->fetch();

                $example = imagecreatefrompng('E:/xampp/htdocs/System_of_electronic_document_circulation/document_examples/canvas.png');
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

                $picName=$data['mail'].'_'.date("Y-m-d_H-i-s");
                imagepng($example, $data['name'].'_'.$picName.'.png');
                imagedestroy($example);
                imagedestroy($userSignature);
                $fName='E:/xampp/htdocs/System_of_electronic_document_circulation/'.$data['name'].'_'.$picName.'.png';

                unlink($signature);
                
                $sql = parent::connection()->prepare('INSERT INTO `docs` VALUES(?,?,?,?,?,?,?)');
                $sql->execute([NULL, $data['mail'], $recipients, $fName, 'unchecked', NULL, "templated"]);

                return $$lang['docMsg'];
            }

            else{
                if(file_exists("E:/xampp/htdocs/System_of_electronic_document_circulation/document_examples/".$documentName."_example.png")){
                    return '<img src="http://localhost/System_of_electronic_document_circulation/document_examples/'.$documentName.'_example.png">';
                }
                else{
                    return "wrong name";
                }
            }
        }

        private function storeHandwrittenDoc($data, $document)
        {
            /*$accural_of_social_scholarship = "Myguschenko@khpi.edu.ua";
            $continuation_of_the_payment_of_the_social_scholarship = "Myguschenko@khpi.edu.ua";
            $removal_of_copies_of_documents_located_in_the_personnel_department = "Myguschenko@khpi.edu.ua";
            $issuance_of_the_original_ZNO = "Myguschenko@khpi.edu.ua";
            $improvement_of_assessment = "Myguschenko@khpi.edu.ua";
            $re_enrollment_of_grades = "Larin@infiz.khpi.edu.ua";
*/
            $picName=$data['sender'].'_'.date("Y-m-d_H-i-s");
            $newDocName = 'E:/xampp/htdocs/System_of_electronic_document_circulation/'.$data['name'].'_'.$picName.'.png';
            rename($document, $newDocName);

            $recievers = $data['name'];
            $sql = parent::connection()->prepare("INSERT INTO `docs` VALUES(?,?,?,?,?,?,?)");
            if($data['name']==="re_enrollment_of_grades"){
                $sql->execute([NULL, $data['sender'],"Larin@infiz.khpi.edu.ua", $newDocName, "unchecked", NULL, "handwritten"]);
            }
            else{
                $sql->execute([NULL, $data['sender'],"Myguschenko@khpi.edu.ua", $newDocName, "unchecked", NULL, "handwritten"]);
            }
            return "Your document was generated and sended to recipient to sign it";
        }

//////////////////////////////////////////////////////////////////////////////////////////////////!!! I CAN  MAKE ONLY ONE FUNCTION WHERE THERE WILL BE CHANGING ONLY NAMES OF DOCUMENTS 
//////////////////////////////////////////////////////////////////////////////////////////////////!!! CAUSE ALL THE REST IS THE SAME
/*       public function recipientList($searchingName){
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
        }*/

    }


?>