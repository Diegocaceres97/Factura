<?php
class Index_model extends Conexion
{
    function __construct(){
parent::__construct();
    }
    function userLogin($email,$pass){
        $where = " WHERE Email = :Email"; //hacemos la verificacion de logeo anteriormente pasado [capturado] en el index de controller
        $param = array('Email' =>$email);//Agregamos el valor al dato correspondiente
        $response = $this->db->select1("*",'usuarios',$where,$param);
       // var_dump($response);//averiguaremos que esta obteniendo el array
if(is_array($response)){
    $response= $response['results'];
if($pass==$response[0]["Password"]){//devuelve la informacion encriptada de la tabla
//este devuelve un true o false (en este caso es true)
$data = array(
    "IdUsuario" => $response[0]["IdUsuario"],
    "Nombre" =>$response[0]["Nombre"],
    "Apellido" => $response[0]["Apellido"],
    "Roles" => $response[0]["Roles"],
    "Imagen"=>$response[0]["Imagen"],
 );
 Session::setSession("User",$data);
 return $data;
}else{
   // echo $pass;
$data = array(
   "IdUsuario" => 0,
);
return $data;
}
}else{
    return $response;
}
    }
}

?>