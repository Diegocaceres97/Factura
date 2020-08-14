<?php
class Compras extends Controllers
{
    function __construct(){
        parent::__construct();
    }
    public function productos(){
        $user = Session::getSession("User");
        if (null!=$user) {//verificamos si se esta logueado
            if("Admin"==$user["Roles"]){
            $this->view->render($this,"productos",null);
        } else {
            header("Location:".URL."Principal/principal");
        }
    }else{
        header("Location:".URL);
    }
        
    }
    public function compras(){
        $user = Session::getSession("User");
        if (null!=$user) {//verificamos si se esta logueado
            if("Admin"==$user["Roles"]){
            $this->view->render($this,"compras",null);
        } else {
            header("Location:".URL."Principal/principal");
        }
    }else{
        header("Location:".URL);
    }
        
    }
    public function getProveedores(){
        // $urlImage = URL."Resource/images/fotos/clientes/".$value["Email"].".png";
        $user = Session::getSession("User");//verificamos que sea un usuario logeado como metodo de seguridad
        if(null != $user){
            $count = 0;
            $dataFilter = null;
            //obtenemos los usuarios solicitados por medio del metodo alojado en el modelo y mandandole estos 3 parametros
            $data = $this->model->getProveedores($_POST["search"],$_POST["page"],$this->page);
            if (is_array($data)) {
                //manejamos los datos devueltos
                $array = $data['results'];
                foreach ($array as $key => $value) {
                    $dataProveedor = json_encode($array[$count]);
                    $urlImage = URL."Resource/images/fotos/Proveedores/".$value["Email"].".png";
                    $url=URL."Proveedores/reportes/?email=".$value["Email"];
                   
                    
                    $dataFilter .= "<tr>".
                    "<td>".
                     
                    "<img width='80' height='60'  src='".$urlImage."'/>".
                    "</td>".
                    "<td>".$value["Proveedor"]."</td>".
                    "<td>".
                    "<a onclick='compras.dataProveedor(".$dataProveedor .")' class='btn modal-trigger'>Select</a> | ".
                    
                    "</td>". 
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
    public function detallesCompras(){
        $user = Session::getSession("User");
        if (null!=$user) {//verificamos si se esta logueado
            if("Admin"==$user["Roles"]){
            if (empty($_POST["Descripcion"])) {
                echo "El campo descripcion es obligatorio";
            } else {
                
            if (empty($_POST["Precio"])) {
                echo "El campo Precio es obligatorio";
            } else {
               $archivo = null;
               $tipo = null;
                $Codigo = $this->model->getCodigo("compras",$_POST["Email"],);//generamos el codigo (que es un ticket aleatorio)
                $Proveedor = $this->model->getProveedor($_POST["IdProveedor"],$_POST["Email"]); //pasos para generar el ticket provee cuando se usa credito (relleno)
               // echo var_dump($Proveedor);
                Session::setSession("Compra",array(
                $_POST["Descripcion"],
                $_POST["Cantidad"],
                $_POST["Precio"],
                0,
                $_POST["IdProveedor"],
                $_POST["Proveedor"],
                $_POST["Email"],
                $_POST["credito"],
                0,
                $Codigo
            ));
            if (is_numeric($Codigo)) {
               if (is_array($Proveedor)) {
                if(isset($_FILES['file'])){//rectifiamos si file esta definido para saber si se a cargado una imagen
                  $tipo = $_FILES['file']["type"];//obtenemos el tipo de imagen
                    $archivo = $_FILES['file']["tmp_name"];//obtenemos los datos o info temporal de nuestros archivos
                }
                $this->image->cargar_imagenSC($tipo,$archivo,$Codigo,"Compras");
                echo json_encode(array( //mandamos al front
                    "Codigo" => $Codigo,
                    "results" => $Proveedor
                ));
               } else {
                   echo $Proveedor;
               }
               
            } else {
                echo $Codigo;
            }
            
            if(isset($_FILES['file'])){//rectifiamos si file esta definido para saber si se a cargado una imagen
                $tipo = $_FILES['file']["type"];//obtenemos el tipo de imagen
                $archivo = $_FILES['file']["tmp_name"];//obtenemos los datos o info temporal de nuestros archivos
            }
            $this->image->cargar_imagenSC($tipo,$archivo,$Codigo,"Compras");
            //echo $Codigo;
            }
            }
            
            }
    }
}
public function detalles(){
    $user = Session::getSession("User");
    if (null!=$user) {//verificamos si se esta logueado
        if("Admin"==$user["Roles"]){
        $this->view->render($this,"detalles",null);
        }else{
header("Location:" .URL."Principal/principal");
        }
    }else{
header("Location:".URL);
        }
}
public function comprar(){
    $user = Session::getSession("User");
    if (null!=$user) {//verificamos si se esta logueado
        if("Admin"==$user["Roles"]){
        $this->model->comprar(
            $this->TCompras(array()),
            $this->TCompras_temp(Session::getSession("Compra"))
        );
        }
}
}
}
?>