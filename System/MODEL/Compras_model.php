<?php
class Compras_model extends Conexion{
    function __construct(){
        parent::__construct();
    }
    function getProveedores($filter,$page,$model){
        $where = " WHERE Proveedor LIKE :Proveedor OR Email LIKE :Email";
        $array = array(
            'Proveedor' => '%'.$filter.'%',//aqui filtraremos el dato dependiendo el dato que pasen
            'Email' => '%'.$filter.'%'
                    );
                    $columns = "IdProveedor,Proveedor,Telefono,Email,Direccion";
                    return $model->paginador($columns,"proveedores","CompraProveedores",$page,$where,$array);
                    //el porque de no colocar en el segundo clientes la c inicial en minuscula es pq llamamos
                    //al metodo pero como ya tiene el get, no es necesario volver a colocar
    }
    public function comprar($model1,$model2){
        echo var_dump($model2);
    }
}
?>