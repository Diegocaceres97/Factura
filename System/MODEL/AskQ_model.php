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
function deleteAsk($Pregunta){
    $where = " WHERE Pregunta LIKE :pregunta";
    $data = $this->db->delete('pregresp',$where,array('pregunta' => $Pregunta));//lo ultimo de esta linea es como el $param 
    //solo que no se puso por ahorrar una linea xD
}
/*function getAsk(){
    return $response = $this->db->select1("*","RP",null,null);
}*/
}
?>