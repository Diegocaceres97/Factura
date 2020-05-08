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
    function cargar_imagen($tipo,$imagen,$email){
        $destino = "./RESOURCE/IMAGES/fotos/".$email.".png";//guardaremos la imagenen este directorio
        if (strstr($tipo,"image")) {//verificamos el tipo de archivo que se esta cargando   
            //guardandolo con el nombre del email
            move_uploaded_file($imagen,$destino);//metodo donde copiaremos la imagen
             
        }else{
$archivo = RQ."IMAGES/fotos/default.png";//RQ ES UNA CONSTANTE DEFINIDA EN CONFIG.PHP
copy($archivo , $destino);//obtenemos el directorio del archivo y luego le indicamos el lugar destino asi lo que copiara
        }//metodo copy es cuando lo obtenemos (en este caso)por post o http
        return $email.".png";
    }
}
?>