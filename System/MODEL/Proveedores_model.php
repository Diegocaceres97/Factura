<?php
class Proveedores_model extends Conexion
{
    function __construct(){
        parent::__construct();
    }
    public function registerProveedores($model1,$model2){
        $where = " WHERE Email = :Email";
        $param = array('Email' =>$model1->Email);
        $response = $this->db->select1("*","proveedores",$where,$param);
        if (is_array($response)) {
           $response = $response["results"];
           if(0==count($response)){
            $value = "(Proveedor,Telefono,Email,Direccion) 
            VALUES (:Proveedor,:Telefono,:Email,:Direccion)";    
            $data = $this->db->insert("proveedores",$model1,$value);
            if (is_bool($data)) {
                $response = $this->db->select1("*","proveedores",$where,$param);
                if (is_array($response)) {
                    $response = $response["results"];
                    $model2->IdProveedor=$response[0]["IdProveedor"];
                    $value = "(Deuda,FechaDeuda,Pago,FechaPago,Ticket,IdProveedor) 
                    VALUES (:Deuda,:FechaDeuda,:Pago,:FechaPago,:Ticket,:IdProveedor)";
                    $data = $this->db->insert("reportes_proveedores",$model2,$value);
                    if (is_bool($data)) {
                        return 0;
                    } else {
                        return $data;
                    }
                } else {
                    return $response;
                }
                
            } else {
                return $data;
            }
             
           }else{
               return 1;
           }
        } else {
            return $response;
        }
    }
    function getProveedores($filter,$page,$model){
        $where = " WHERE Proveedor LIKE :Proveedor OR Email LIKE :Email";
        $array = array(
            'Proveedor' => '%'.$filter.'%',//aqui filtraremos el dato dependiendo el dato que pasen
            'Email' => '%'.$filter.'%'
                    );
                    $columns = "IdProveedor,Proveedor,Telefono,Email,Direccion";
                    return $model->paginador($columns,"proveedores","Proveedor",$page,$where,$array);
                    //el porque de no colocar en el segundo clientes la c inicial en minuscula es pq llamamos
                    //al metodo pero como ya tiene el get, no es necesario volver a colocar
    }
    public function dataProveedor($email){
        $where = " WHERE Email = :Email";
        $param = array('Email' =>$email);
        $response1 = $this->db->select1("*","proveedores",$where,$param);
        if(is_array($response1)){
return json_encode($response1);
        }else{
            return $response1;
        }
    }
    public function editProve($model,$idProveedor){//el modelo contiene la clase anonima
        $where = " WHERE Email = :Email";
        $response = $this->db->select1("*","proveedores",$where,array('Email' => $model->Email));
        if (is_array($response)) {
        $response = $response["results"];
        $value = "Proveedor = :Proveedor,Telefono = :Telefono,Email = :Email,Direccion = :Direccion";
        $where=" WHERE IdProveedor = ".$idProveedor;
        if (0==count($response)) {
            $data = $this->db->update("proveedores",$model,$value,$where);
            if (is_bool($data)) {
                return 0;
            } else {
                return $data;
            }
         } else{
             if ($response[0]['IdProveedor'] == $idProveedor) {
                $data = $this->db->update("proveedores",$model,$value,$where);
                if(is_bool($data)){
                return 0;
                }else{
return $data;
                }
             } else {
                return 1;
             }
             
         }
        }else{
            return $response;
        }
    }
}
?>