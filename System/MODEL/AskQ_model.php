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
}
?>