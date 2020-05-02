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
        $array = array(
$_POST["nid"],
$_POST["nombre"],
$_POST["apellido"],
$_POST["telefono"],
$_POST["email"],
$_POST["password"],
$_POST["usuario"],
$_POST["role"],
        "Imagen");
        $data = $this->model->registerUser($this->userClass($array));
        if ($data == 1) {//verificacion de email no utilizado
            echo "EMAIL REGISTRADO";
        }else{
echo $data;
        }
    }
public function destroySession(){
    Session::destroy();
    header("Location:".URL);//url es una constante que direccion al index
}
}

?>