<?php
namespace Core\Validator;
//include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

trait Validator{

    static public function returnMessage(string $key, $language)
    {
        if(isset($language)){
            return $language[$key];
        }
        else{
            return 'Wrong language value';
        }
    }

    public function validateMail(string $data, string $language)
    {       
        include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

        $pattern='/[a-zA-Z_\s.]+@infiz.khpi.edu.ua/';
        if(preg_match($pattern, $data)!=1){
            return self::returnMessage('errorRegDomain',$$language);
        }
        return true;
    }



    public function validateByLanguage(array $data, string $language)
    {
        foreach($data as $key => $value){
            if(!preg_match('/^[А-ЩЬЮЯЄІЇҐа-щьюяєіїґ \-\.,\?!\'\" \d]+$/u',$data[$key] )){
                return 'only ukr';
            }
        }

        if(preg_match('/[0-9]+/',$data['initials'] )){
            return "name can't contain numbers";
        }

        return true;
    }

    public function checkEmptity(array $data, string $language)
    {
        include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

        foreach($data as $key => $valuse){
            $data[$key] = trim($data[$key]);
            if($data[$key]===''){
               return self::returnMessage('docError1',$$language);

            }
        }
        return true;
    }

    public function validateFile($file){

    }
}
