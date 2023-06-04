<?php

    namespace Core;

trait QueryBuilder
{

    public function makeQuery(string $queryType, string $query, $params=null, $fetchType='fetchAll', $fetchMode=\PDO::FETCH_OBJ)
    {
        try{
            $sql = $this->pdo->prepare($query);
                
            if($params!=null){
                if(gettype($params)=='array'){
                    $sql->execute($params);
                }
                else{
                    $sql->execute([$params]);
                }
                
            }
            else{
                $sql->execute();
            }
                if($queryType=='select'){
                    if($fetchMode!=\PDO::FETCH_OBJ){
                        return $sql->$fetchType($fetchMode);
                    }
                    return $sql->$fetchType();
                }
                else{
                    return 0;
                }
        }

        catch (\PDOException $e){
            echo 'Database Error:'.$e->getMessage();
        }
    }

}