<?php
namespace Core\Validator;
//include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

trait Validator{

    protected function validateMail(string $data, string $language)
    {       
        include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

        $pattern='/[a-zA-Z_\s.]+@infiz.khpi.edu.ua/';
        if(preg_match($pattern, $data)!=1){
            return $$language['errorRegDomain'];
        }
        return true;
    }



    protected function validateByLanguage(array $data, string $language)
    {
        foreach($data as $key => $value){
            if(!preg_match('/[А-Яа-яЇїІіЄєҐґ\s\d\-`]+/',$data[$key] )){
                return 'only ukr';
            }
        }

        if(preg_match('/[0-9]+/',$data['initials'] )){
            return "name can't contain numbers";
        }

        return true;
    }

    protected function checkEmptity(array $data, string $language)
    {
        include 'E:/xampp/htdocs/System_of_electronic_document_circulation/languages.php';

        foreach($data as $key => $valuse){
            $data[$key] = trim($data[$key]);
            if($data[$key]===''){
               return $$language['docError1'];

            }
        }
        return true;
    }

    protected function validateFile($file){

    }
}
?>