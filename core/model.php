<?php

    class Model{

        protected $pdo;
        protected $answer = array();

        protected function connection(){
            $host = "localhost";
            $userLog = "root";
            $passwordUser = "";
            $dbname = "document circulating system";
            $dsn = 'mysql:host='.$host.';dbname='.$dbname;
            $this->pdo = new PDO($dsn, $userLog, $passwordUser);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $this->pdo;
        }

        public function get_data($param=null){

        }

    }

?>