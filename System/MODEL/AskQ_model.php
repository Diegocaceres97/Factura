<?php
class AskQ_model extends Conexion{
    public function registerA($user){
    $value = "(Pregunta,R1,R2,R3,RP) VALUES (:ask,:ans,:ansd,:anst,:sp)";
    $data = $this->db->insert("pregresp",$user,$value);
    if (is_bool($data)) {//identificacion de registro satisfactorio
        return 0;
    }else{
        return $data;
    }   
}
function getAsk($filter,$page,$model){
    $where = " WHERE Pregunta LIKE :pregunta";
    $array = array(
'pregunta' => '%'.$filter.'%'//aqui filtraremos el dato dependiendo el dato que pasen
    );
    $columns = "IdPregunta,Pregunta,R1,R2,R3,RP";
    return $model->paginador($columns,"pregresp","Ask",$page,$where,$array);
}

function getAsks($filter){
    $where = " WHERE IdPregunta LIKE :pv";
    $param = array('pv' =>$filter);
    $response = $this->db->select1("*","pregresp",$where,$param);
    if(is_array($response)){
return $response = $response['results'];
    }else{
        return "$response";
    }
}
function deleteAsk($Pregunta){
    $where = " WHERE Pregunta LIKE :pregunta";
    $data = $this->db->delete('pregresp',$where,array('pregunta' => $Pregunta));//lo ultimo de esta linea es como el $param 
    //solo que no se puso por ahorrar una linea xD
}
/*function getAsk(){
    return $response = $this->db->select1("*","RP",null,null);
}*/
function editAsk($user,$pregunta){
    $where = " WHERE Pregunta LIKE :pv";
    $param = array('pv' =>$pregunta);
    $response = $this->db->select1("*","pregresp",$where,$param);
    if(is_array($response)){
       $response = $response['results'];//este array contiene la información del usuario obtenido por la clausula de arriba
        $value = "Pregunta = :ask, R1 = :ans,R2 = :ansd,R3 = :anst,RP = :sp";//cadena de texto que utilizaremos para insertar los datos por medio de la query
    $where = " WHERE IdPregunta LIKE ".$pregunta;
    if(0==count($response)){//verificamos si este arreglo contiene algun registro y los contará dado el caso
//si devuelve el valor de 0 significa que no esta repetido o con algun registro
$data = $this->db->update("pregresp",$user,$value,$where);//user tiene el valor de los atributos y lo convertiremos en un array
if (is_bool($data)) {
return 0;
}     else{
return $data;
}   }}}
}
?>