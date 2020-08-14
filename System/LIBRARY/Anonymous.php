<?php
declare (strict_types=1);//con el valor de 1 indicamos que esta propiedad sera estricta
class Anonymous
{
    public function userClass($array){
        return new class($array)
        {//creamos las variables tipo public con la que asignaremos datos del array extraido
public $NID;
public $Nombre;
public $Apellido;
public $Telefono;
public $Email;
public $Password;
public $Usuario;
public $Roles;
public $Imagen;
function __construct($array){//inicializamos
    $this->NID = $array[0];//obtenemos el dato de acuerdo a la posicion del array
$this->Nombre = $array[1];
$this->Apellido = $array[2];
$this->Telefono = $array[3];
$this->Email = $array[4];
$this->Password = $array[5];
$this->Usuario = $array[6];
$this->Roles = $array[7];
$this->Imagen = $array[8];
}
        };
        
    }
    public function clientesClass(array $array){//especificamos que parametro recibira (tipo)
return new class($array){
    var $NID;//Referencia a las tabla de la base de datos
    var $Nombre;
    var $Apellido;
    var $Email;
    var $Direccion;
    var $Telefono;
    var $Creditos;
    function __construct($array){ //metodo constructor de la clase anonima para poder iniciar estos atributos/propiedades
        $this->NID = $array[0];
        $this->Nombre = $array[1];
        $this->Apellido = $array[2];
        if(is_numeric($array[3])){
            $this->Telefono = $array[3];
        }
        $this->Email = $array[4];
        $this->Direccion = $array[5];
        $this->Creditos = $array[6];
    }
};
    }
    public function reportClientesClass(array $array){
    return new class($array){
var $Deuda;
var $FechaDeuda;
var $Pago;
var $FechaPago;
var $Ticket;
var $IdClientes;
function __construct($array){
    $this->Deuda = $array[0];
    $this->FechaDeuda = $array[1];
    $this->Pago = $array[2];
    $this->FechaPago = $array[3];
    $this->Ticket = $array[4];
    $this->IdClientes = $array[5];
}
    };
    }
    public function ticketClass(array $array){
        return new class($array){
            var $Propietario;
            var $Deuda;
            var $FechaDeuda;
            var $Pago;
            var $FechaPago;
            var $Ticket;
            var $Email;
            function __construct($array){
                $this->Propietario = $array[0];
                $this->Deuda = $array[1];
                $this->FechaDeuda = $array[2];
                $this->Pago = $array[3];
                $this->FechaPago = $array[4];
                $this->Ticket = $array[5];
                $this->Email = $array[6];
            }
        };
    }
    public function proveedorClass(array $array){
    return new class($array){
        var $Proveedor;
        var $Telefono;
        var $Email;
        var $Direccion;
    function __construct($array){
        $this->Proveedor=$array[0];
        $this->Telefono=$array[1];
        $this->Email=$array[2];
        $this->Direccion=$array[3];
    }
    };
    }
    public function reportProveedores(array $array){
        return new class($array){
            var $Deuda;
            var $FechaDeuda;
            var $Pago;
            var $FechaPago;
            var $Ticket;
            var $IdProveedor;
        function __construct($array){
            $this->Deuda = $array[0];
            $this->FechaDeuda = $array[1];
            $this->Pago = $array[2];
            $this->FechaPago = $array[3];
            $this->Ticket = $array[4];
            $this->IdProveedor = $array[5];
        }
        };
}
public function TCompras(array $array){
    return new class($array){
        var $Descripcion;
        var $Cantidad;
        var $Precio;
        var $Importe;
        var $IdProveedor;
        var $Proveedor;
        var $Email;
        var $IdUsuario;
        var $Usuario;
        var $Role;
        var $Dia;
        var $Mes;
        var $Year;
        var $Fecha;
        var $Codigo;
        var $Credito;
        function __construct($array){
            if(0 <count($array)){
                $this->Descripcion = $array[0];
                $this->Cantidad = $array[1];
                $this->Precio = $array[2];
                $this->Importe = $array[3];
                $this->IdProveedor = $array[4];
                $this->Proveedor = $array[5];
                $this->Email = $array[6];
                $this->IdUsuario = $array[7];
                $this->Usuario = $array[8];
                $this->Role = $array[9];
                $this->Dia = $array[10];
                $this->Mes = $array[11];
                $this->Year = $array[12];
                $this->Fecha = $array[13];
                $this->Codigo = $array[14];
                $this->Credito = $array[15];
            }
        }
    };
}
public function TCompras_temp(array $array){
return new class($array){
    public $ID;
    public $Descripcion;
    public $Cantidad;
    public $Precio;
    public $Importe;
    public $IdProveedor;
    public $Proveedor;
    public $Email;
    public $Credito;
    public $Fecha;
    public $Codigo; 
    function __construct($array){
        if(0 <count($array)){
            $this->ID = $array[0];
            $this->Descripcion = $array[1];
            $this->Cantidad = $array[2];
            $this->Precio = $array[3];
            $this->Importe = $array[4];
            $this->IdProveedor = $array[5];
            $this->Proveedor = $array[6];
            $this->Email = $array[7];
            $this->Credito = $array[8];
            $this->Fecha = $array[9];
            $this->Codigo = $array[10];
        }} 
};
}
}
?>