<?php
require "config.php";
$url = $_GET["url"] ?? "Index/index";
//Esta variable nos sirve para saber y capturar los datos en la URL
//La que esta despues del ? es un respaldo por si no llega a tener 
//Datos la URL se iria para el index automaticamente tanto en controller como en metodo

//Todo esto de aqui abajo se hará pensando en que no pase nada por la URL
$controller = "";
$method = "";
$params = "";
$url = explode ("/", $url); //El explode convierte a array
if(isset($url[0])){//Verificamos si tiene datos
    $controller = $url[0];
}
if(isset($url[1])){
    if($url[1] !=''){
        $method = $url[1];
    }
   
}
if(isset($url[2])){
    if($url[1] !=''){//rectificamos si pasa un parametro en la posicion 1 de la url
        $params = $url[2];//ahora en la dos que seria el email
    }
   
}
spl_autoload_register(function($class){//obtenemos el nombre de clase
    //utilizada
    if(file_exists(LBS.$class.".php")){//verificamos si el archivo existe
//Con este metodo solo necesitaremos un require para poder acceder
//a todos los metodos y controlladores
require LBS.$class.".php";//invocamos el archivo
}});//con esto invocamos clases
//$obj = new Controllers();
//echo $controller."-----".$method;
require 'CONTROLLER/Error.php';
$error = new Errors();
//Siguiendo pasos
$controllersPath = "CONTROLLER/".$controller.'.php';//Invocamos el controlador en posicion 0 arriba
if(file_exists($controllersPath)){//verificar si existe
require $controllersPath;
    //instanciamos la clase
$controller = new $controller();
if(isset($method)){
    if(method_exists($controller, $method)){
        if(isset($params)){//verificamos si obtiene datos el objeto
            $controller -> {$method}($params);
        }else{
            $controller -> {$method}();//verificamos si ese metodo existe en el controlador 
        }
    }else{
        $error -> error();
    }
}
}else{
$error -> error();
}
?>