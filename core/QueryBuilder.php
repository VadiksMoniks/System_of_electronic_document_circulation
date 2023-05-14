<?php

    namespace Core;
/*тут необхідно спочатку розглянути усі можливі варіанти запитів
оскільки я використовую лише SELECT INSERT UPDATE DELETE - то основних методів буде лише 4
далі треба врахувати метод WHERE, який буде додавати конструкцію WHERE до запиту 
 */
trait QueryBuilder
{
    public function select($neededValues='*',$tableName, $params, $returningtype=\PDO::FETCH_OBJ)
    {
        try{
            $sql = $this->pdo->prepare("SELECT $neededValues FROM $tableName");
            $sql->execute([$params]);
            return $sql->fetchAll($returningtype);
        }
        catch   (\PDOException $e){
            echo 'Database Connection Error:'.$e->getMessage();
        }
    }

    public function insert($tableName, $params)
    {
        try{
            $this->pdo->prepare();
        }
        catch   (\PDOException $e){
            echo 'Database Connection Error:'.$e->getMessage();
        }
    }

    public function update($tableName, $params)
    {
        try{
            $this->pdo->prepare();
        }
        catch   (\PDOException $e){
            echo 'Database Connection Error:'.$e->getMessage();
        }
    }

    public function delete($tableName)
    {
        try{
            $this->pdo->prepare();
        }
        catch   (\PDOException $e){
            echo 'Database Connection Error:'.$e->getMessage();
        }
    }

    public function where($fields,$filterParams)
    {   
        if(gettype($filterParams)=='array'){
            foreach($filterParams as $key){

            }
        }
        else{

        }
        return "WHERE "
    }
}