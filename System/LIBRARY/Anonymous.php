<?php
class Anonymous
{
    public function userClass($array){
        return new class($array)
        {
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
}
?>