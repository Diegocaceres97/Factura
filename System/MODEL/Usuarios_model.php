<?php
class Usuarios_model extends Conexion
{
    function __construct(){
        parent::__construct();
    }
    function getRoles(){
        return $response = $this->db->select1("*","roles",null,null);
    }
    public function registerUser($user){
        $where = " WHERE Email = :Email";
        $param = array('Email' =>$user->Email);
        $response = $this->db->select1("*","usuarios",$where,$param);
        if(is_array($response)){
$response = $response['results'];//obtenemos los datos almacenado en el objeto con el nombre re
if (0 == count($response)) {//este metodo devuelve un valor de tipo entero dependiendo de los datos almacenados en el arreglo
    //si entra por aca quiere decir que no esta registrado nee la BD ==0
    $value = "(NID,Nombre,Apellido,Email,Password,Telefono,Usuario,Roles,Imagen) VALUES (:NID,:Nombre,:Apellido,:Email,:Password,:Telefono,:Usuario,:Roles,:Imagen)";
    $data = $this->db->insert("usuarios",$user,$value);
    if ($data==true) {//identificacion de registro satisfactorio
        return 0;
    }else{
        return $data;
    }
    
} else {
    return 1;
}

        }else{
            return $response;
        }
    }
   
    function getUsers($filter){
        $where = " WHERE NID LIKE :NID OR Nombre LIKE :Nombre OR Apellido LIKE :Apellido";
        $array = array(
'NID' => '%'.$filter.'%',//aqui filtraremos el dato dependiendo el dato que pasen
'Nombre' => '%'.$filter.'%',
'Apellido' => '%'.$filter.'%'
        );
        $columns = "IdUsuario,NID,Nombre,Apellido,Email,Telefono,Usuario,Roles,Imagen";
        return $this->db->select1($columns,"usuarios",$where, $array);
    }
}


?>