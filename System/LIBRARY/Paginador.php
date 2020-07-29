<?php
class Paginador extends Conexion{
public function __construct(){
    parent:: __construct();
}
public function paginador($columns,$table,$method,$page,$where,$array){
$_pagi_enlace=null;
//cantidad de resultados por pagina
$_pagi_cuantos=6;
//cantidad de enlaces que se mostraran como maximo en la barra de navegación
$_pagi_nav_num_enlaces= 3;
//Decidimos si queremos que se muestren los errores en mysql
$_pagi_mostrar_errores=false;
//definimos que ira en el enlace a la pagina anterior
$_pagi_nav_anterior=" &laquo; Anterior ";//podría ir un tag <img> o lo que sea
//definimos qué íra en el enlace a la página siguiente
$_pagi_nav_siguiente = " Siguiente &raquo; ";//podria ir un tag <img> o lo que sea
if(!isset($_pagi_nav_primera)){
    $_pagi_nav_primera = " &laquo; Primero";
}
if(!isset($_pagi_nav_ultima)){
    $_pagi_nav_ultima = "Último &raquo; ";
}
if(empty($page)){
$_pagi_actual = 1;
}else{
$_pagi_actual=$page;
}
//consultando la bd y la tabla

$response = $this->db->select1($columns,$table,$where,$array);
if (is_array($response)) {
    $_pagi_result = $response["results"];
} else {
    return $response;
}
$_pagi_totalReg=count($_pagi_result);//con esto sabemos la cantidad de registros que obtenemos de la consulta
//calculamos la cantidad de páginas (saldrá un decimal)
//con ceil() redondeamos y $_pagi_totalPags sera el numero total (entero de paginas que tendremos)
$_pagi_totalPags=ceil($_pagi_totalReg / $_pagi_cuantos);
$_pagi_navegacion_temporal = array();//se creo para almacenar los enlaces de nuestro paginador
if($_pagi_actual != 1){//si no estamos en lapágina 1 ponemos el enlace de primero
    $_pagi_url=1;//será el número de página al que enlazamos
    $_pagi_navegacion_temporal[]= "<a id='paginas1' href='#' onclick='"."get".$method."(".$_pagi_url.")'>$_pagi_nav_primera</a>";
//si no estamos en la página 1. Ponemos en enlace anterior
$_pagi_url = $_pagi_actual -1;
$_pagi_navegacion_temporal[]= "<a id='paginas1' href='#' onclick='"."get".$method."(".$_pagi_url.")'>$_pagi_nav_anterior</a>";
}
//la variable $_pagi_nav_num_enlaces sirve para definir cuantos enlaces con numeros de paginas se mostrará como máximo
if (!isset($_pagi_nav_num_enlaces)) {
    //si no se definio la variable $_pagi_nav_num_enlaces se asume que se mostrara todos los numeros de paginas en los enlaces
    $_pagi_nav_desde=1;//desde la primera
    $_pagi_nav_hasta=$_pagi_totalPags; //a la ulima
} else {
    //si se definio $_pagi_nav_num_enlaces
    //Calculamos el intervalo para sumar  y restar a partir de la pagina actual
    $_pagi_nav_intervalo = ceil($_pagi_nav_num_enlaces/2)-1;
    //calculamos que numero de pagina se mostrará
    $_pagi_nav_desde = $_pagi_actual - $_pagi_nav_intervalo;
    //calculamos hasta que numero de pagina se mostrara
    $_pagi_nav_hasta = $_pagi_actual + $_pagi_nav_intervalo;

    //si $_pagi_nav_desde es un numero negativo
    if ($_pagi_nav_desde < 1) {
        //le restamos la cantidad sobrante al final para mantener el numero de enlaces que se quiere mostrar
        $_pagi_nav_hasta-=($_pagi_nav_desde - 1);
        //establecemos $_pagi_nav_desde como 1
        $_pagi_nav_desde = 1;
    } 
    if ($_pagi_nav_hasta > $_pagi_totalPags) {
        //le restamos la cantidad excedida al comienzo para mantener el numero de enlaces que se quiere mostrar
        $_pagi_nav_desde -= ($_pagi_nav_hasta - $_pagi_totalPags);
        //establecemos $_pagi_totalPags como total de paginas
        $_pagi_nav_hasta = $_pagi_totalPags;
        if($_pagi_nav_desde < 1){
            $_pagi_nav_desde = 1;
        }  
    }
}
for($_pagi_i = $_pagi_nav_desde; $_pagi_i <=$_pagi_nav_hasta; $_pagi_i++){
    //desde la pagina 1 hasta la ultima
    if ($_pagi_i == $_pagi_actual) {//indicará que esta en la pagina actual
        //y este escribira el numero de la pagina pero sin enlace y en negrita
        $_pagi_navegacion_temporal[] = "<span id='paginas2'>$_pagi_i</span>";
    }else{
        $_pagi_navegacion_temporal[]= "<a id='paginas1' href='#' onclick='"."get".$method."(".$_pagi_i.")'>$_pagi_i</a>";
}
    }
    if($_pagi_actual < $_pagi_totalPags){
        //si no estamos en la ultima pagina ponemos en enlace "siguiente"
        $_pagi_url = $_pagi_actual+1;
        $_pagi_navegacion_temporal[]= "<a id='paginas1' href='#' onclick='"."get".$method."(".$_pagi_url.")'>$_pagi_nav_siguiente</a>";

        //si no estamos en la ultima pagina ponemos en enlace "ultima"
        $_pagi_url = $_pagi_totalPags;
        $_pagi_navegacion_temporal[]= "<a id='paginas1' href='#' onclick='"."get".$method."(".$_pagi_url.")'>$_pagi_nav_ultima</a>";
}

   
/*
****************************************************************
//OBTENCION DE LOS REGISTROS QUE SE OBTENDRAN EN LA PAGINA ACTUAL
*****************************************************************
*/
$_pagi_navegacion = implode($_pagi_navegacion_temporal);
//calculamos desde que registro se mostrara en esta pagina
//recordemos que el conteo empieza desde 0
$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
//Consulta sql que devuelve la $cantidad de registros empezando desde $pag_inicial
$response = $this->db->select2($columns,$table,$_pagi_inicial,$_pagi_cuantos,$where,$array);
if (is_array($response)) {
    $_pagi_result2 = $response["results"];
} else {
    return $response;
}
/*
*******************************************************
GENERACION DE LA INFORMACION DE LOS REGISTROS MOSTRADOS
*******************************************************
*/
//Numero del primer registro de la pagina actual
$_pagi_desde = $_pagi_inicial + 1;
//Numero del ultimo registro de la pagina actual
$_pagi_hasta=$_pagi_inicial + $_pagi_cuantos;
if ($_pagi_hasta > $_pagi_totalReg) {
    //si estamos en la ultima pagina
    //el ultimo registro de la pagina actual seria igual al numero de registros
    $_pagi_hasta = $_pagi_totalReg;
}
$_pagi_info= "del <b>$_pagi_desde</b> al <b>$_pagi_hasta</> de <b>$_pagi_totalReg</b>";
return array(
     "results" => $_pagi_result2,
     "pagi_navegacion" => $_pagi_navegacion,
     "pagi_info" => $_pagi_info
);
}
}


?>