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
        try {
            $this->db->pdo->beginTransaction();
            $user = Session::getSession("User");
        $importe = "$".number_format($model2->Precio * $model2 ->Cantidad);
        $model1->Descripcion = $model2->Descripcion; //invocamos propiedades y se la asignamos (inicilizandolos)
        $model1->Cantidad = $model2->Cantidad;
        $model1->Precio ="$".number_format($model2->Precio);
        $model1->Importe = $importe;
        $model1->IdProveedor = $model2->IdProveedor;
        $model1->Proveedor = $model2->Proveedor;
        $model1->Email = $model2->Email;
        $model1->IdUsuario = $user["IdUsuario"];
        $model1->Usuario = $user["Nombre"]."".$user["Apellido"];
        $model1->Role = $user["Roles"];
        $model1->Dia = date("d");
        $model1->Mes = date("m");
        $model1->Year = date("y");
        $model1->Fecha = date("d/m/y");
        $model1->Codigo = $model2->Codigo;  
        $model1->Credito = $model2->Credito;
//esto se conoce como metodo de transaccion ya que se inserta simultaneamente y si no se cumple dicha 'promesa' no se podria
        $query1 = "INSERT INTO compras(Descripcion,Cantidad,Precio,Importe,IdProveedor,Proveedor,Email,IdUsuario,Usuario,Role,Dia,Mes,Year,Fecha,Codigo,Credito) VALUES 
        (:Descripcion,:Cantidad,:Precio,:Importe,:IdProveedor,:Proveedor,:Email,:IdUsuario,:Usuario,:Role,:Dia,:Mes,:Year,:Fecha,:Codigo,:Credito)";    
       //insertamos la informacion en la tabla compras
        $sth = $this->db->pdo->prepare($query1);//con PDO preparamos la query para la inserccion
        $sth->execute((array)$model1);
        //throw new Exception("Error");
 
 $model2->Importe = $importe;   
 $model2->Fecha = date("d/m/Y");
 $query2 = "INSERT INTO compras_temp(Descripcion,Cantidad,Precio,Importe,IdProveedor,Proveedor,Email,Credito,Fecha,Codigo) VALUES 
        (:Descripcion,:Cantidad,:Precio,:Importe,:IdProveedor,:Proveedor,:Email,:Credito,:Fecha,:Codigo)";    
 $sth = $this->db->pdo->prepare($query2);//con PDO preparamos la query para la inserccion
 $sth->execute((array)$model2);
 $valor = (bool)$model2->Credito;
 $proveedor = Session::getSession("reportProveedor");
 if ($valor) {
   
 if (is_array($proveedor)) {
     if (0!=count($proveedor)) {
        $importe = $model2->Precio * $model2->Cantidad;
        $deuda = (float)str_replace("$","",$proveedor["Deuda"]);
        $deuda2 = $deuda + $importe;
        $deuda3 = "$".number_format($deuda2); //la formateamos a un tipo de dato string
    $data = array(
        "Deuda" => $deuda3,
        "FechaDeuda" => date("d/m/Y"),
        "Ticket" => $proveedor["Ticket"]
    );
     $query3 = "UPDATE reportes_proveedores SET Deuda = :Deuda, FechaDeuda = 
     :FechaDeuda, Ticket = :Ticket WHERE IdReportes = ".$proveedor["IdReportes"];
    // echo $proveedor["IdReportes"];
      $sth = $this->db->pdo->prepare($query3);//con PDO preparamos la query para la inserccion
      $sth->execute($data);
    } else {
        throw new Exception($proveedor);
     }
     
 } else {
    throw new Exception($proveedor);
 }
 
$FechaDeuda = date("d/m/Y"); //agarra la fecha un dia despues
    }else{
$deuda3 = $proveedor["Deuda"];
$FechaDeuda = $proveedor["FechaDeuda"];
    }
 //al llegar acá se le indica a la transacción que todo fue OK y que se insertará conjuntamente
 $query4 = "INSERT INTO ticket (Propietario,Deuda,FechaDeuda,Pago,FechaPago,Ticket,Email)
 VALUES (:Propietario, :Deuda, :FechaDeuda, :Pago, :FechaPago, :Ticket, :Email)";
   $data = array(
    "Propietario" => "Proveedor",
    "Deuda" => $deuda3,
    "FechaDeuda" => $FechaDeuda,
    "Pago" => $proveedor["Pago"],
    "FechaPago" => $proveedor["FechaPago"],
    "Ticket" => $proveedor["Ticket"],
    "Email" => $model2->Email
);
$sth = $this->db->pdo->prepare($query4);//con PDO preparamos la query para la inserccion
$sth->execute($data);
 $this->db->pdo->commit();
      return 0;  
    } catch (\Throwable $e) {
            $this->db->pdo->rollBack(); //revertimos nuestra BD al estado anterior
            return $e->getMessage();
        }
        
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
                    $dataProveedor= array(
"IdReportes" => $data[0]["IdReportes"],
"Deuda" => $data[0]["Deuda"],
"FechaDeuda" => $data[0]["FechaDeuda"],
"Pago" => $data[0]["Pago"],
"FechaPago" => $data[0]["FechaPago"],
"Ticket" => $ticket,
"IdProveedor" => $data[0]["IdProveedor"]
                    );
                    Session::setSession("reportProveedor",$dataProveedor);
                    return $dataProveedor;
                } else {
                    return $Proveedor;      
                }
                
            } else {
                return $ticket;
            }
            
    }
    public function getCompras($filter,$page,$model){
        $where = " WHERE Descripcion LIKE :Descripcion";
        $array = array(
            'Descripcion' => '%'.$filter.'%'//aqui filtraremos el dato dependiendo el dato que pasen
                    );
                    return $model->paginador("*","compras","Compras",$page,$where,$array);
    }
}
?>