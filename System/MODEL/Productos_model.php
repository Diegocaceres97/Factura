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
        Session::setSession("compras_temp",array(
            'Codigo' =>$data[0]["Codigo"],
            'Precio' =>$data[0]["Precio"],
            'Cantidad' =>$data[0]["Cantidad"]
        ));//almacenamos el codigo de barra (compra) del producto
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
public function registrarProducto($model1,$model2){
    try {
       $this->db->pdo->beginTransaction();
       $query1 = "INSERT INTO productos(Codigo,Descripcion,Precio,Departamento,Categoria,Descuento,Dia,Mes,Year,Fecha,Compra,Image) VALUES 
        (:Codigo,:Descripcion,:Precio,:Departamento,:Categoria,:Descuento,:Dia,:Mes,:Year,:Fecha,:Compra,:Image)";    
$sth = $this->db->pdo->prepare($query1);//con PDO preparamos la query para la inserccion
$sth->execute((array)$model1);  

$query2 = "INSERT INTO bodega(Codigo,Existencia,Dia,Mes,Year,Fecha) VALUES 
(:Codigo,:Existencia,:Dia,:Mes,:Year,:Fecha)";  
$sth = $this->db->pdo->prepare($query2);//con PDO preparamos la query para la inserccion
$sth->execute((array)$model2);
$this->db->pdo->commit();
return 0;    
} catch (\Throwable $th) {
      $this->db->pdo->rollBack();
      return $th->getMessage();
    }
}
}
?>