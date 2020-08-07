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
    public function getReporteProve($email){
        $where = " WHERE Email = :Email";
        $response1 = $this->db->select1("*","proveedores",$where,array('Email'=>$email));
        if(is_array($response1)){
            $response1=$response1["results"];
            if(0 != count($response1)){
                $where = " WHERE IdProveedor = :IdProveedor";
                $response2 = $this->db->select1("*","reportes_proveedores",$where,array('IdProveedor' => $response1[0]["IdProveedor"]));
                if (is_array($response2)) {
                    $response2 = $response2['results'];
                    if (0!= count($response2)) {//verificamos si tiene datos
                        $data= array(
                            "Proveedor" => $response1[0]["Proveedor"],
                            "Email" => $response1[0]["Email"],
                            "IdReportes" => $response2[0]["IdReportes"],
                            "Deuda" => $response2[0]["Deuda"],
                            "FechaDeuda" => $response2[0]["FechaDeuda"],
                            "Pago" => $response2[0]["Pago"],
                            "FechaPago" => $response2[0]["FechaPago"],
                            "Ticket" => $response2[0]["Ticket"],
                            "IdProveedor" => $response2[0]["IdProveedor"]
                        );
                        Session::setSession("reportProveedor",$data);//almacenamos la info por el lado del servidor 
                        //por medio de la sesión (que es estatica)
                        return $data;
                    } else {
                        return 0;
                    }
                    
                } else {
                    return $response2;
                }
            }else{
                return 0;
            }
        }else{
            return $response1;
        }
    }
    public function setPagos($model1,$model2,$idReporte){
        echo $Ticket=Codigo::Ticket($this->db,"ticket");
    }
    }

?>