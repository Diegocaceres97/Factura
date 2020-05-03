<?php
class QueryManager
{
    private $pdo;
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
            return true;
        } catch (PDOException$e) {
            return $e->getMessage();
            //throw $th;
        }
    }
}


?>