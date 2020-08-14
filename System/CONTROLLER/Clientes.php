<?php
class Clientes extends Controllers
{
  
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
                            $archivo = null;
                            $tipo = null;
                            
                            $array1 = array($_POST["nid"],$_POST["nombre"],$_POST["apellido"],$_POST["telefono"],$_POST["email"],$_POST["direccion"],
                            $_POST["creditos"]);
                            $array2 = array($_POST["creditos"],"--/--/--","$0","--/--/--","0",0);
                            $data = $this->model->registerCliente($this->clientesClass($array1),
                            $this->reportClientesClass($array2));
                       // var_dump($this->clientesClass($array));//le pasamos la funcion a la clase en Anon
                       if ($data==1) {
                           echo "el email ".$_POST["email"]." ya esta registrado";
                       } else {
                           if ($data == 0) {
                            if(isset($_FILES['file'])){//rectifiamos si file esta definido para saber si se a cargado una imagen
                                $tipo = $_FILES['file']["type"];//obtenemos el tipo de imagen
                                $archivo = $_FILES['file']["tmp_name"];//obtenemos los datos o info temporal de nuestros archivos
                            }
                            $this->image->cargar_imagenSC($tipo,$archivo,$_POST["email"],"clientes");
                            echo 0;
                           }else{
                           echo $data;
                           }
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
                "<a href='#modal1'  onclick='dataCliente(".$dataCliente .")' class='btn modal-trigger'>Edit</a> | ".
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
$data = $this->model->getReporteCliente($_POST["email"]);
if (is_array($data)) {
    echo json_encode(array(//convertimos este array en un JSON
        "array" => $data,
        "data" => 1 //indicamos que tenemos registros por eso el 1
    ));
} else {
    echo json_encode( array(
        "data" => 0,

    ));
}

        }else{
            echo json_encode( array(
                "data" => 0,

            ));
        }
        }
    }
}
public function setPagos(){
    $user = Session::getSession("User");//verificamos que sea un usuario logeado como metodo de seguridad
    if(null != $user){
        date_default_timezone_set('UTC');
        if ("Admin"==$user["Roles"]) {
        $pago = (float) $_POST["pagos"];
        if(is_float($pago) && 0 < $pago){
           // $pago = number_format($pago); //lo asignamos para que sea en millares
       // $array=json_decode($_POST["report"],true);
        //$array = $array["array"];
        $array = Session::getSession("reportCliente");
        $deuda = str_replace("$","",$array["Deuda"]);
        $deuda = str_replace(",","",$deuda);
        $fechaDeuda = $array["FechaDeuda"];
      //  $deuda = (float)$deuda;
        //$deuda = number_format($deuda);
        if ($deuda==0) {
            echo "El cliente no contiene deuda";
        } else {
            if ($deuda < $pago) {
            echo "Se ha sobrepasado del pago de la Deuda";
            } else {
              $deuda =$deuda - $pago;
              $pago = number_format($pago);
              $arrayReport = array(
                  "$".number_format($deuda),
                  $fechaDeuda,
                  "$".$pago,
                  date("d-m-Y"),
                  $array["Ticket"],
                  $array["IdClientes"]
              );
              $ticket = array(
                  "Cliente" ,
                  "$".number_format($deuda),
                  $fechaDeuda,
                  "$".$pago,
                  date("d-m-Y"),
                  $array["Ticket"],
                  $array["Email"]
              );
              $this->model->setPagos($this->reportClientesClass($arrayReport),
              $this->ticketClass($ticket),$array["IdReportes"]);
            }
            
        }
        }else{
            echo "el dato ingresado no es correcto";
        }
        }}
}
public function editCliente(){
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
                        $array1 = array($_POST["nid"],$_POST["nombre"],$_POST["apellido"],$_POST["telefono"],$_POST["email"],$_POST["direccion"],
                        $_POST["creditos"]);
                       $data = $this->model->editCliente($_POST["idCliente"],$this->clientesClass($array1));
                       if ($data==1) {
                           echo "el email ".$_POST["email"]." ya esta registrado";
                       } else {
                           if ($data==0) {
                            $archivo = null;
                            $tipo = null;
                            if(isset($_FILES['file'])){//rectifiamos si file esta definido para saber si se a cargado una imagen
                                $tipo = $_FILES['file']["type"];//obtenemos el tipo de imagen
                                $archivo = $_FILES['file']["tmp_name"];//obtenemos los datos o info temporal de nuestros archivos
                            }
                            $this->image->cargar_imagenSC($tipo,$archivo,$_POST["email"],"clientes");
                           } else {
                            return $data;
                           }
                           
                           
                       }
                       
                        /* $archivo = null;
                        $tipo = null;
                        if(isset($_FILES['file'])){//rectifiamos si file esta definido para saber si se a cargado una imagen
                            $tipo = $_FILES['file']["type"];//obtenemos el tipo de imagen
                            $archivo = $_FILES['file']["tmp_name"];//obtenemos los datos o info temporal de nuestros archivos
                        }
                        $this->image->cargar_imagenSC($tipo,$archivo,$_POST["email"],"clientes");
                        
                        $array2 = array($_POST["creditos"],"--/--/--","$0","--/--/--","0",0);
                        $data = $this->model->registerCliente($this->clientesClass($array1),
                        $this->reportClientesClass($array2));
                   // var_dump($this->clientesClass($array));//le pasamos la funcion a la clase en Anon
                   if ($data==1) {
                       echo "el email ".$_POST["email"]." ya esta registrado";
                   } else {
                       echo $data;
                   }*/
                   
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
public function getTickets(){//recordemos que todo esto que capturemos se enviará al JS por medio del JSON
    $user = Session::getSession("User");
    if (null!=$user) {
        if ("Admin"==$user["Roles"]) {
            $dataFilter = null;
            $data = $this->model->getTickets($_POST["search"],$_POST["page"],$this->page);
            if (is_array($data)) {
                foreach ($data['results'] as $key => $value) {
                   $dataFilter .="<tr>" .
                   "<td>".$value["Deuda"]."</td>".
                   "<td>".$value["FechaDeuda"]."</td>".
                   "<td>".$value["Pago"]."</td>".
                   "<td>".$value["FechaPago"]."</td>".
                   "<td>".$value["Ticket"]."</td>".
                   "</td>".
                   "</tr>";
                }
                $paginador = "</p> <p>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
                echo json_encode( array(//lo convertimos a json para que el codigo por el lado del cliente capture esta info y verla en vista usuario
                    "dataFilter" => $dataFilter,
                    "paginador" => $paginador
                ));
            } else {
                return $data;
            }
            
        }
    }
}
public function exportarExcel(){
    $user = Session::getSession("User");
    if (null!=$user) {
        if ("Admin"==$user["Roles"]) {
            $archivo = null;
            $title=null;
            $data=null;
            if (1==$_POST["valor"]) {
                $archivo="TicketClientes.xls";
                $title = 'Ticket';
                $data = $this->model->getTickets($_POST["search"],$_POST["page"],$this->page);
            }else{
                $archivo="Clientes.xls";
                $title = 'Clientes';
                $data = $this->model->getClientes($_POST["search"],$_POST["page"],$this->page);
            }
           
            if (is_array($data)) {
                $this->export->exportarExcel($data['results'],$archivo,$title);
            } else {
                return $data;
            }
            
        }
}
}
}
?>