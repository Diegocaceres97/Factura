<?php
class Session
{
    static function star(){
        @session_start();//andamos inicializando variables de sesión
    }
    static function getSession($name){
        return $_SESSION[$name];//obtenemos la información de las variables de sesión
    }
    static function setSession($name,$data){//creara las variables de sesión
return $_SESSION[$name] = $data;
    }
    static function destroy(){
        @session_destroy();
    }
}

?>