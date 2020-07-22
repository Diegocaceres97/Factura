<?php
class Clientes extends Controllers
{
    private $archivo = null;
    private $tipo = null;
    function __construct(){
        parent::__construct();
    }
    public function clientes(){
        if (null!=Session::getSession("User")) {//verificamos si se esta logueado
            $this->view->render($this,"clientes",null);
        } else {
            header("Location:".URL);
        }
        
    }
    public function registerCliente(){
        $user = Session::getSession("User");
        if (null!=$user) {
            if ("Admin"==$user["Roles"]) {
                if(empty($_POST["nombre"])){
                    echo "el campo nombre es obligario";
            }else{
                if(empty($_POST["apellido"])){
                    echo "el campo apellido es obligario";
            }else{
                if(empty($_POST["nid"])){
                    echo "el campo nid es obligario";
                        }else{
                            if(empty($_POST["telefono"])){
                                echo "el campo telefono es obligario";
                        }else{
                            if(empty($_POST["email"])){
                                echo "el campo email es obligario";
                        }else{
                            if(empty($_POST["direccion"])){
                                echo "el campo direccion es obligario";
                        }else{
                            if(isset($_FILES['file'])){//rectifiamos si file esta definido para saber si se a cargado una imagen
                                $tipo = $_FILES['file']["type"];//obtenemos el tipo de imagen
                                $archivo = $_FILES['file']["tmp_name"];//obtenemos los datos o info temporal de nuestros archivos
                            }
                            $this->image->cargar_imagenSC($tipo,$archivo,$_POST["email"],"clientes");
                            $array1 = array($_POST["nid"],$_POST["nombre"],$_POST["apellido"],$_POST["telefono"],$_POST["email"],$_POST["direccion"],
                            $_POST["creditos"],"imagen");
                            $array2 = array("$0","--/--/--","$0","--/--/--","0",0);
                            $data = $this->model->registerCliente($this->clientesClass($array1),
                            $this->reportClientesClass($array2));
                       // var_dump($this->clientesClass($array));//le pasamos la funcion a la clase en Anon
                       if ($data==1) {
                           echo "el email ".$_POST["email"]." ya esta registrado";
                       } else {
                           echo $data;
                       }
                       
                        }
                        }
            }
            }
        }
    }
} else {
            echo "No tiene autorizacion";
        }
    }
}

public function getCreditos(){
    $user = Session::getSession("User");
        if (null!=$user) {
$data = $this->model->getCreditos();
if(is_array($data)){
echo json_encode($data);
}else{
echo $data;//este seria el error
}}
}
public function getClientes(){
    // $urlImage = URL."Resource/images/fotos/clientes/".$value["Email"].".png";
    $user = Session::getSession("User");//verificamos que sea un usuario logeado como metodo de seguridad
    if(null != $user){
        $count = 0;
        $dataFilter = null;
        //obtenemos los usuarios solicitados por medio del metodo alojado en el modelo y mandandole estos 3 parametros
        $data = $this->model->getClientes($_POST["search"],$_POST["page"],$this->page);
        if (is_array($data)) {
            //manejamos los datos devueltos
            $array = $data['results'];
            foreach ($array as $key => $value) {
                $dataCliente = json_encode($array[$count]);
                $urlImage = URL."Resource/images/fotos/clientes/".$value["Email"].".png";
                $url=URL."Clientes/reportes/?email=".$value["Email"];
                if ("Admin"==$user["Roles"]) {
                    $botonReporte="<a href='".$url."' class='btn green lighten-1 modal-trigger'>Reportes</a>";
                } else {
                    $botonReporte="";
                }
                
                $dataFilter .= "<tr>".
                "<td>".
                 
                "<img width='80' height='60'  src='".$urlImage."'/>".
                "</td>".
                "<td>".$value["Nombre"]."</td>".
                "<td>".$value["Apellido"]."</td>".
                "<td>".
                "<a href='#modal1'  onclick='dataUser(".$dataCliente .")' class='btn modal-trigger'>Edit</a> | ".
                $botonReporte
                ."</td>". 
                "</tr>";
                $count++;

            }
            $paginador = "<p>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
            echo json_encode( array(//lo convertimos a json para que el codigo por el lado del cliente capture esta info y verla en vista usuario
                "dataFilter" => $dataFilter,
                "paginador" => $paginador
            ));
        } else {
            echo $data;
        }
        
    }
}
public function reportes(){
    $user = Session::getSession("User");//verificamos que sea un usuario logeado como metodo de seguridad
    if(null != $user){
        if ("Admin"==$user["Roles"]) {
            //echo $email;
        $this->view->render($this,"reportes", null);
        //otra forma de pasar datos desde el servidor y url:
            //$this->view->render($this,"reportes", $_GET["email"]);
        }else{
            header("Location:".URL."Clientes/clientes");
        }
    }
}
public function getReporteCliente(){
    $user = Session::getSession("User");//verificamos que sea un usuario logeado como metodo de seguridad
    if(null != $user){
        if ("Admin"==$user["Roles"]) {
            //verificamos si el dato obtenido es valido
        if(filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
echo "bien";
        }else{
            echo json_encode( array(
                "data" => 0,

            ));
        }
        }
    }
}
}
?>