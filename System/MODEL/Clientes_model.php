<?php
class Clientes_model extends Conexion
{
    function __construct(){
parent::__construct();//inicializamos el constructor de Conexion
    }
    function getCreditos(){
        return $response = $this->db->select1("*","creditos",null,null);//esto retornara los datos de la busquedad SQL
    }
}

?>