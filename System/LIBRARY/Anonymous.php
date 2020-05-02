<?php
class Anonymous
{
    public function userClass($array){
        return new class($array)
        {
private $NID;
private $Nombre;
private $Apellido;
private $Telefono;
public $Email;
private $Password;
private $Usuario;
private $Roles;
private $Imagen;
function __construct($array){
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