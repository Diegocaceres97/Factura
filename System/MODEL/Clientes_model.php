<?php
class Clientes_model extends Conexion
{
    function __construct(){
parent::__construct();//inicializamos el constructor de Conexion
    }
    function getCreditos(){
        return $response = $this->db->select1("*","creditos",null,null);//esto retornara los datos de la busquedad SQL
    }
    public function registerCliente($cliente,$r_cliente){
        $where = " WHERE Email = :Email";
        $param = array('Email' =>$cliente->Email);
        $response = $this->db->select1("*","clientes",$where,$param);
        if (is_array($response)) {//si es un array es que contiene datos
            $response = $response['results'];
            if (0==count($response)) {//si pasa este condicional significa que el email no esta registrado
                $value = "(NID,Nombre,Apellido,Email,Telefono,Direccion,Creditos) 
                VALUES (:NID,:Nombre,:Apellido,:Email,:Telefono,:Direccion,:Creditos)";    
                $data = $this->db->insert("clientes",$cliente,$value); 
                if (is_bool($data)) {//si es true quiere decir que insertó bien los datos
                    $response = $this->db->select1("*","clientes",$where,$param);//Ultimo dato insertado aqui mismo
if (is_array($response)) {
    $response= $response['results'];
    $r_cliente->IdClientes=$response[0]["IdClientes"];//Guardamos en el IdClientes el id del cliente que va relacionado en esta tabla reportes
    $value = "(Deuda,FechaDeuda,Pago,FechaPago,Ticket,IdClientes) 
    VALUES (:Deuda,:FechaDeuda,:Pago,:FechaPago,:Ticket,:IdClientes)";
    $data = $this->db->insert("reportes_clientes",$r_cliente,$value); 
    if (is_bool($data)) {
       return 0;
    } else {
        return $data;
    }
    
} else {
    return $data;
}

                } else {
                    return $data;
                }
                 
            } else {
               return 1;//si esta registrado
            }
            
        } else {
            return $response;//esta seria una excepcion
        }
        
    }
    function getClientes($filter,$page,$model){
        $where = " WHERE NID LIKE :NID OR Nombre LIKE :Nombre OR Apellido LIKE :Apellido";
        $array = array(
            'NID' => '%'.$filter.'%',//aqui filtraremos el dato dependiendo el dato que pasen
            'Nombre' => '%'.$filter.'%',
            'Apellido' => '%'.$filter.'%'
                    );
                    $columns = "IdClientes,NID,Nombre,Apellido,Email,Telefono,Direccion,Creditos";
                    return $model->paginador($columns,"clientes","Clientes",$page,$where,$array);
                    //el porque de no colocar en el segundo clientes la c inicial en minuscula es pq llamamos
                    //al metodo pero como ya tiene el get, no es necesario volver a colocar
    }
    function getReporteCliente($email){
        $where = " WHERE Email = :Email";
        $param = array('Email' =>$email);
        $response1 = $this->db->select1("*","clientes",$where,$param);
   if(is_array($response1)){
$response1=$response1["results"];
if(0 != count($response1)){
$where = " WHERE IdClientes = :IdClientes";
$response2 = $this->db->select1("*","reportes_clientes",$where,array('IdClientes' => $response1[0]["IdClientes"]));
if (is_array($response2)) {
    $response2 = $response2['results'];
    if (0!= count($response2)) {//verificamos si tiene datos
        $data= array(
            "Nombre" => $response1[0]["Nombre"],
            "Apellido" => $response1[0]["Apellido"],
            "Email" => $response1[0]["Email"],
            "IdReportes" => $response2[0]["IdReportes"],
            "Deuda" => $response2[0]["Deuda"],
            "FechaDeuda" => $response2[0]["FechaDeuda"],
            "Pago" => $response2[0]["Pago"],
            "FechaPago" => $response2[0]["FechaPago"],
            "Ticket" => $response2[0]["Ticket"],
            "IdClientes" => $response2[0]["IdClientes"]
        );
        Session::setSession("reportCliente",$data);//almacenamos la info por el lado del servidor 
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
public function setPagos($model,$idReporte){
    $value = "Deuda = :Deuda, FechaDeuda = :FechaDeuda, Pago = :Pago,
    FechaPago = :FechaPago, Ticket = :Ticket,IdClientes = :IdClientes";
    $where = " WHERE IdReportes = ".$idReporte;
    $data = $this->db->update("reportes_clientes",$model,$value,$where);
    if (is_bool($data)) {
        return 0;
    } else {
        return $data;
    }
    
   // echo var_dump($model);
}
}
?>