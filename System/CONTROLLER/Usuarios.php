<?php
class Usuarios extends Controllers
{
    function __construct(){
        parent::__construct();//Se invoca al metodo controlador de la clase controller 
      
    }
    public function usuarios(){
        if (null != Session::getSession("User")){//comprobara si ha destruido datos de sesion
            $this->view->render($this,"usuarios"); //invocamos el objeto render desde controllers
        } else {//asi evitamos que entre despés de salido
            header("Location:".URL);
        }       
    }
    function getRoles(){
        $data = $this->model->getRoles();//Obtenemos el resultado de la funcion en el model usuarios
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
        }
    }
    public function registerUser(){
        if (isset($_FILES['file'])) {//comprobamos si esta definida para pasar a capturar (imagen)
           $tipo = $_FILES['file']["type"];//obtenemos el tipo de imagen
           $archivo = $_FILES['file']["tmp_name"];//obtenemos los datos o info temporal de nuestros archivos
           $imagen = $this->model->cargar_imagen($tipo,$archivo,$_POST["email"]); //mandamos la info correspondiente para registrar la imagen en nuestra carpeta
        } else {
            $imagen = "default.png";//por si el usuario registrado no carga ninguna foto
        }
        
        $array = array(
$_POST["nid"],$_POST["nombre"],$_POST["apellido"],$_POST["telefono"],$_POST["email"],
password_hash($_POST["password"], PASSWORD_DEFAULT),//encriptamiento de la clave
$_POST["usuario"],
$_POST["role"],$imagen); 
        
        $data = $this->model->registerUser($this->userClass($array));
        if ($data == 1) {//verificacion de email no utilizado
            echo "EMAIL REGISTRADO";
        }else{
echo $data;
        }
    }
    public function getUsers(){
        $dataFilter = null;
        $data = $this->model->getUsers($_POST["filter"]);
    }
public function destroySession(){
    Session::destroy();
    header("Location:".URL);//url es una constante que direccion al index
}
}

?>