<?php
class Usuarios_model extends Conexion
{
    function __construct(){
        parent::__construct();
    }
    function getRoles(){
        return $response = $this->db->select1("*","roles",null,null);
    }
}


?>