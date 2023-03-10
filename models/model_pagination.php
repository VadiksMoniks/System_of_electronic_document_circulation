<?php

    class Model_Pagination extends Model{

        public function paginate($current_page=null, $recordsPerPage=null)
        {
            $list = '';

            if(gettype($current_page)!="integer"){
                $current_page = 1;
            }
            if(!isset($current_page)){
                $current_page = 1;
            }
            if($current_page <=0){
                $current_page = 1;
            }
            if(!isset($recordsPerPage)){
                $recordsPerPage = 10;
            }
            //mb add more params for searching like username
            if($current_page==1){

                $recordsSql = parent::connection()->prepare("SELECT * FROM `docs` LIMIT ?");
                $recordsSql->execute([$recordsPerPage+1]);

                $records = $recordsSql->fetchAll(PDO::FETCH_ASSOC);
                if($records==null){
                    return 'error';
                }
                for($i=0; $i<count($records)-1; $i++){
                        $list.='<ul><li>'.$records[$i]['sender'].'</li><li>'.$records[$i]['reciever'].'</li><li><a href="http://localhost/System_of_electronic_document_circulation/index.php/admin/checkDocument?n='.basename($records[$i]['document_name']).'">'.basename($records[$i]['document_name']).'</a></li></ul>';
                }

                return $list;
            }
            else{
                return 1;
            }



        }

    }

?>