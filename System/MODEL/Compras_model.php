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
    public function getCodigo($table,$email){
        return Codigo::Ticket($this->db,$table,null,$email); //vamos a generar un ticket para nuestra tabla de compras_temp (codigo)
    }
    public function comprar($model1,$model2){
        echo var_dump($model2);
    }
    public function getProveedor($IdProveedor,$Email){
        $where = " WHERE IdProveedor = :IdProveedor";
            $array = array(
'IdProveedor' => $IdProveedor
            );
            $ticket = Codigo::Ticket($this->db,"ticket","Proveedor",$Email);
            if (is_numeric($ticket)) {
                $Proveedor = $this->db->select1("*","reportes_proveedores",$where,$array);
                if (is_array($Proveedor)) {
                    $data = $Proveedor["results"];
                    return array(
"IdReportes" => $data[0]["IdReportes"],
"Deuda" => $data[0]["Deuda"],
"FechaDeuda" => $data[0]["FechaDeuda"],
"Pago" => $data[0]["Pago"],
"FechaPago" => $data[0]["FechaPago"],
"Ticket" => $ticket,
"IdProveedor" => $data[0]["IdProveedor"]
                    );
                } else {
                    return $Proveedor;      
                }
                
            } else {
                return $ticket;
            }
            
    }
}
?>