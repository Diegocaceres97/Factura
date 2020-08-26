<?php
class Productos_model extends Conexion
{
    function __construct(){
        parent::__construct();
    }
    public function getCompra($filter,$page,$model){
    $where = " WHERE Descripcion LIKE :Descripcion";
    $array = array(
        'Descripcion' => '%'.$filter.'%'//aqui filtraremos el dato dependiendo el dato que pasen
                );
                return $model->paginador("*","compras_temp","CompraTempo",$page,$where,$array);
}
public function getProducto($idTemp){
    $where = " WHERE IdTemp LIKE :IdTemp";
    $array = array(
        'IdTemp' => $idTemp//aqui filtraremos el dato dependiendo el dato que pasen
                );
                $Producto = $this->db->select1("*","compras_temp",$where,$array);
if(is_array($Producto)){
    return $Producto["results"];
}else{
    return $Producto;
}                
}
}
?>