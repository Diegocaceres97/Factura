<?php
class Uploadimage{
    function cargar_imagen($tipo,$imagen,$email,$carpeta){
        $d=rand(1,30);
        $nuev = $d."-".$email;
        $destino = "./RESOURCE/IMAGES/fotos/".$carpeta."/".$nuev.".png";//guardaremos la imagenen este directorio
        if (strstr($tipo,"image")) {//verificamos el tipo de archivo que se esta cargando   
            //guardandolo con el nombre del email  
            move_uploaded_file($imagen,$destino);//metodo donde copiaremos la imagen          
        }else{
            if(null == $imagen){//si pasa por acá quiere decir que andamos registrando un usuario con imagen nula
                $archivo = RQ."IMAGES/fotos/".$carpeta."/default.png";
            }else{
                $archivo = RQ."IMAGES/fotos/".$carpeta."/".$imagen;
            }
//RQ ES UNA CONSTANTE DEFINIDA EN CONFIG.PHP
copy($archivo , $destino);//obtenemos el directorio del archivo y luego le indicamos el lugar destino asi lo que copiara
        }//metodo copy es cuando lo obtenemos (en este caso)por post o http
        return $nuev.".png";
    } 
    function cargar_imagenSC($tipo,$imagen,$email,$carpeta){//este metodo no genera random image
            $destino = "./RESOURCE/IMAGES/fotos/".$carpeta."/".$email.".png";//guardaremos la imagenen este directorio
            if (strstr($tipo,"image")) {//verificamos el tipo de archivo que se esta cargando   
                //guardandolo con el nombre del email
                move_uploaded_file($imagen,$destino);//metodo donde copiaremos la imagen
    
            }else{
    $archivo = RQ."IMAGES/fotos/default.png";//RQ ES UNA CONSTANTE DEFINIDA EN CONFIG.PHP
    $archivo = RQ."IMAGES/fotos/".$carpeta."/default.png";//RQ ES UNA CONSTANTE DEFINIDA EN CONFIG.PHP
    copy($archivo , $destino);//obtenemos el directorio del archivo y luego le indicamos el lugar destino asi lo que copiara
            }//metodo copy es cuando lo obtenemos (en este caso)por post o http
            return $email.".png";
    }

}

?>