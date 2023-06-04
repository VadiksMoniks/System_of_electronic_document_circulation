<?php
    namespace Models;

    include 'languages.php';
    
    use Core\Model;

    //include './core/validator.php';
    class Model_Documents extends \Core\Model{

        //use Core\Validator\Validator;
        
        public function showExample($document_name){

            if(isset($document_name)){
                if(trim($document_name)!=''){
                    return $this->documentCreation($document_name);
                
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

<<<<<<< HEAD
            if($data['initials']==""){
                return $$lang['docError1'];
=======
            $slice = array_slice($data, 5, 4);
            $this->answer['answer'] = $this->checkEmptity($slice, $lang);
            if($this->answer['answer']!=1){
                if(isset($_FILES['file']['tmp_name'])){
                    unlink($_FILES['file']['tmp_name']);
                }
            }

          $this->answer['answer'] = $this->validateByLanguage($slice, $lang);  
            if($this->answer['answer']!=1){
                if(isset($_FILES['file']['tmp_name'])){
                    unlink($_FILES['file']['tmp_name']);
                }
                return json_encode($this->answer);
            }       

            if (empty($_FILES['file']['name'])){
                $this->answer['answer']= self::returnMessage('docError4', $$lang);
                if(isset($_FILES['file']['tmp_name'])){
                    unlink($_FILES['file']['tmp_name']);
                }
                return json_encode($this->answer);
            }
            

            $filetype = new \SplFileInfo($_FILES['file']['name']);
            
            if($filetype->getExtension() != 'png'){
                $this->answer['answer']= self::returnMessage('docError5', $$lang);
                unlink($_FILES['file']['tmp_name']);
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

            //$this->answer['answer']=self::storeHandwrittenDoc($data, $removeDoc);
            //return json_encode($this->answer);
            $this->answer['answer'] = self::storeHandwrittenDoc($data, $removeDoc, $lang);
            return json_encode($this->answer);

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

                // imagealphablending($userSignature, false);
                // imagesavealpha($userSignature, true);
                // $transparent = imagecolorallocatealpha($userSignature, 0, 0, 0, 127);
                // imagefill($userSignature, 0, 0, $transparent);

                imagecopy($example, $userSignature, 1329, 965, 0, 0 ,126, 100);

                $picName=$data['mail'].'_'.date("Y-m-d_H-i-s");
                imagepng($example, $data['name'].'_'.$picName.'.png');
                imagedestroy($example);
                imagedestroy($userSignature);
                $fName='E:/xampp/htdocs/System_of_electronic_document_circulation/'.$data['name'].'_'.$picName.'.png';

                unlink($signature);
                
                $sql = $this->pdo->prepare('INSERT INTO `docs` VALUES(?,?,?,?,?,?,?)');
                $sql->execute([NULL, $data['mail'], $recipients, $fName, 'unchecked', NULL, "templated"]);

                return self::returnMessage('docMsg',$$lang);
            }
>>>>>>> development

            else{
                if(file_exists("E:/xampp/htdocs/System_of_electronic_document_circulation/document_examples/".$documentName."_example.png")){
                    //return '<img src="http://localhost/System_of_electronic_document_circulation/document_examples/'.$documentName.'_example.png">';
                    array_push($this->answer,['answer'=>$documentName, 'type'=>"image"]);
                    return $this->answer;
                }
                else{
                    array_push($this->answer,['answer'=>"Wrong name", 'type'=>"msg"]);
                    return $this->answer; 
                }
            }
        }

        private function storeHandwrittenDoc($data, $document, $lang)
        {
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

//////////////////////////////////////////////////////////////////////////////////////////////////!!! I CAN  MAKE ONLY ONE FUNCTION WHERE THERE WILL BE CHANGING ONLY NAMES OF DOCUMENTS 
//////////////////////////////////////////////////////////////////////////////////////////////////!!! CAUSE ALL THE REST IS THE SAME
        public function recipientList($searchingName){
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
            return self::returnMessage('docMsg',$$lang);
        }

        public function documentList($name, $lang)
        {
            include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';
            $documents = [
                $$lang['doc1.headers'] => $$lang['doc2.docs'].'/'.$$lang['doc3.docs'],
                $$lang['doc2.headers'] => $$lang['doc4.docs'].'/'.$$lang['doc5.docs'],
                $$lang['doc1.docs'] => $$lang['doc1.docs'],
                $$lang['doc6.docs'] => $$lang['doc6.docs'],
                $$lang['doc7.docs'] => $$lang['doc7.docs'],
                $$lang['doc8.docs'] => $$lang['doc8.docs'],
                $$lang['doc3.headers'] => $$lang['doc9.docs'].'/'.$$lang['doc10.docs'],
                $$lang['doc11.docs'] => $$lang['doc11.docs'],
                $$lang['doc12.docs'] => $$lang['doc12.docs'],
                $$lang['doc13.docs'] => $$lang['doc13.docs'],
                $$lang['doc14.docs'] => $$lang['doc14.docs'],
                $$lang['doc15.docs'] => $$lang['doc15.docs'],
            ];

            $links = [
                $$lang['doc1.headers'] => 'formating?name=returning_to_study_on_a_repeat_course/formating?name=providing_a_repeat_course',
                $$lang['doc2.headers'] => 'formating?name=granting_academic_leave/formating?name=extension_of_academic_leave',
                $$lang['doc1.docs'] => 'formating?name=voluntary_deduction',
                $$lang['doc6.docs'] => 'formating?name=renewal_to_higher_education_institution',
                $$lang['doc7.docs'] => 'formating?name=transfer_from_the_budget_to_the_contract',
                $$lang['doc8.docs'] => 'formating?name=change_of_personal_data_(surname)',
                $$lang['doc3.headers'] => 'handwritten?name=accural_of_social_scholarship/handwritten?name=continuation_of_the_payment_of_the_social_scholarship',
                $$lang['doc11.docs'] => 'handwritten?name=voluntary_deduction',
                $$lang['doc12.docs'] => 'handwritten?name=removal_of_copies_of_documents_located_in_the_personnel_department',
                $$lang['doc13.docs'] => 'handwritten?name=issuance_of_the_original_ZNO',
                $$lang['doc14.docs'] => 'handwritten?name=improvement_of_assessment',
                $$lang['doc15.docs'] => 'handwritten?name=re_enrollment_of_grades',
            ];

            $this->answer['answer'] = $documents[$name];
            $this->answer['links'] = $links[$name];
            return json_encode($this->answer);
        }

    }
