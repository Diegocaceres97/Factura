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
    $data = $Producto["results"];
    $codigo = Codigo::getCodeBarra($this->db,"productos");
    if (is_numeric($codigo)) {
        Session::setSession("compras_temp",$data[0]["Codigo"]);//almacenamos el codigo de barra (compra) del producto
        return array($data[0],$codigo);
    }else{
        return $codigo;
    }
}else{
    return $Producto;
}                
}
public function getCodigo(){
    return Codigo::getCodeBarra($this->db,"productos");
}
}
?>