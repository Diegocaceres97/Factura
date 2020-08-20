<?php
class QueryManager
{
    public $pdo;
    function __construct($USER, $PASS, $DB){
        try {
            $this -> pdo = new PDO('mysql:host=localhost;dbname='.$DB.';charset=utf8',$USER, $PASS,
        [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //eSTOS SON PARAMETROS CON CONEXION DE PROPIEDADES
            //ayuda a ser mas segura la conexion a la bd y evita inyecciones sql ademas de manejar escepciones
            // de mejor manera
        ]); 
        } catch (PDOException $e) {
            print 'Error'. $e ->getMessage();
            die();
        }
    }
    function select1($attr,$table,$where,$param){
     //   echo $param;
        try {
            $where = $where ?? "";
            $query = "SELECT ".$attr." FROM ".$table.$where;
            $sth = $this->pdo->prepare($query);
            $sth->execute($param);
            $response = $sth->fetchALL(PDO::FETCH_ASSOC);
            return array("results" => $response);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        $pdo=null;
    }
    function insert($table,$param,$value){
        try {
            $query ="INSERT INTO ".$table.$value;
            $sth = $this->pdo->prepare($query);
            $sth->execute((array)$param);
           // $lastId = $this->pdo->lastInsertId();//Obtenemos la ultima id Auto incrementable colocada
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
            //throw $th;
        }
        $pdo=null;
    }
    function update($table,$param,$value,$where){
    try {
        $query ="UPDATE ".$table." SET ".$value.$where;
            $sth = $this->pdo->prepare($query);
            $sth->execute((array)$param);
            return true;
    } catch (PDOException $e) {
        return $e->getMessage();
        //throw $th;
    }
    $pdo=null;
    }
    function delete($table,$where,$param){
        try {
            $query ="DELETE FROM ".$table.$where;
            $sth = $this->pdo->prepare($query);
            $sth->execute((array)$param);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
            //throw $th;
        }
        $pdo=null;
    }  
    function select2($attr,$table,$_pagi_inicial,$_pagi_cuantos,$where,$param){
        //   echo $param;
           try {
               //$columns,$table,$_pagi_inicial,$_pagi_cuantos,$where,$array
               $query = "SELECT ".$attr." FROM ".$table.$where." LIMIT $_pagi_inicial,$_pagi_cuantos";
               $sth = $this->pdo->prepare($query);
               $sth->execute($param);
               $response = $sth->fetchALL(PDO::FETCH_ASSOC);
               return array("results" => $response);
           } catch (PDOException $e) {
               return $e->getMessage();
           }
           $pdo=null;
       }
}
?>