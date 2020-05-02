<?php
class Conexion 
{
    function __construct(){
        $this ->db = new QueryManager('root','','sistem_facturacion'); //mandamos los parametros a QUERYMANAGER
    }
}

?>