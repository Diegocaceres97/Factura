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
    function editUser($user,$idUsuario){
        $where = " WHERE Email = :Email";
        $param = array('Email' =>$user->Email);
        $response = $this->db->select1("*","usuarios",$where,$param);
        if(is_array($response)){
            $response = $response['results'];//este array contiene la información del usuario obtenido por la clausula de arriba
            $value = "NID = :NID, Nombre = :Nombre,Apellido = :Apellido,Email = :Email,Password = :Password,Telefono = :Telefono,
            Usuario = :Usuario, Roles = :Roles,Imagen = :Imagen";//cadena de texto que utilizaremos para insertar los datos por medio de la query
        $where = " WHERE IdUsuario = ".$idUsuario;
        if(0==count($response)){//verificamos si este arreglo contiene algun registro y los contará dado el caso
//si devuelve el valor de 0 significa que no esta repetido o con algun registro
$data = $this->db->update("usuarios",$user,$value,$where);//user tiene el valor de los atributos y lo convertiremos en un array
if ($data) {
    return 0;
}     else{
    return $data;
}   
}else{
            if ($response[0]['IdUsuario']==$idUsuario) {//si es del mismo usuario el email igual podrá registrar
                $data = $this->db->update("usuarios",$user,$value,$where);
                if ($data) {
                    return 0;
                }     else{
                    return $data;
                }   
            }else{
                return "El email ya esta registrado";
            }
        }
        }else{
            return $response;
        }
    }
    function getUser($filter){
        $where = " WHERE IdUsuario = :IdUsuario";
        $param = array('IdUsuario' =>$filter);
        $response = $this->db->select1("*","usuarios",$where,$param);
        if(is_array($response)){
return $response = $response['results'];
        }else{
            return $response;
        }
    }

}

?>