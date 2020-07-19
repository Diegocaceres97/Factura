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
            $this->view->render($this,"clientes");
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
                            $array = array($_POST["nombre"],$_POST["apellido"],$_POST["nid"],$_POST["telefono"],$_POST["email"],$_POST["direccion"],
                            $_POST["creditos"],"imagen");
                        var_dump($this->clientesClass($array));//le pasamos la funcion a la clase en Anon
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
}
?>