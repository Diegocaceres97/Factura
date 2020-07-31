<?php
class Proveedores extends Controllers
{
    function __construct(){
        parent::__construct();
    }
    public function proveedores(){
        if (null!=Session::getSession("User")) {//verificamos si se esta logueado
            $this->view->render($this,"proveedores",null);
        } else {
            header("Location:".URL);
        }
    }
    public function registrar(){
        $user = Session::getSession("User");
        if (null!=$user) {
            if ("Admin"==$user["Roles"]) {//verificamos si se esta logueado
            $this->view->render($this,"registrar",null);
        } }else {
            header("Location:".URL);
        }
    }
    public function registerProve(){
        $user = Session::getSession("User");
        if (null!=$user) {
            if ("Admin"==$user["Roles"]) {//verificamos si se esta logueado
           if (empty($_POST["proveedor"])) {
              echo "El campo proveedor es obligatorio";
           } else {
              if (empty($_POST["telefono"])) {
                  echo "el campoo telefono es obligatorio";
              } else {
                  if (empty($_POST["email"])) {
                      echo "el campo email es obligatorio";
                  } else {
                      if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                      if (empty($_POST["direccion"])) {
                          echo "el campo direccion es obligatorio";
                      } else {
                          $array1 = array(
                              $_POST["proveedor"],$_POST["telefono"],
                              $_POST["email"],$_POST["direccion"]
                          );
                         // echo var_dump($this->proveedorClass($array1));
                         $array2 = array("$0","--/--/--","$0","--/--/--","0",0);
                         //echo var_dump($this->reportProveedores($array2));
                         echo $data = $this->model->registerProveedores($this->proveedorClass($array1),
                         $this->reportProveedores($array2));
                         if ($data==1) {
                            echo "el email ".$_POST["email"]." ya esta registrado";
                        } else {
                            if ($data == 0) {
                             if(isset($_FILES['file'])){//rectifiamos si file esta definido para saber si se a cargado una imagen
                                 $tipo = $_FILES['file']["type"];//obtenemos el tipo de imagen
                                 $archivo = $_FILES['file']["tmp_name"];//obtenemos los datos o info temporal de nuestros archivos
                             }
                             $this->image->cargar_imagenSC($tipo,$archivo,$_POST["email"],"Proveedores");
                             echo 0;
                            }else{
                            echo $data;
                            }
                        }
                         
                      }
                    }else{
                        echo "el campo email no es valido";
                    } 
                  }
                  
              }
              
           }
           
        } }else {
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
                    $dataCliente = json_encode($array[$count]);
                    $urlImage = URL."Resource/images/fotos/Proveedores/".$value["Email"].".png";
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
}

?>