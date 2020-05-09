<?php
class Usuarios extends Controllers
{
    function __construct(){
        parent::__construct();//Se invoca al metodo controlador (__contruct) de la clase controller 
      
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
        $archivo = null;
        $tipo = null;
        //si no definimos la variable file quiere decir que estará nombrada o con valor null
        if (isset($_FILES['file'])) {//comprobamos si esta definida para pasar a capturar (imagen)
           $tipo = $_FILES['file']["type"];//obtenemos el tipo de imagen
           $archivo = $_FILES['file']["tmp_name"];//obtenemos los datos o info temporal de nuestros archivos 
        } 
        $imagen = $this->image->cargar_imagen($tipo,$archivo,$_POST["email"],"usuarios"); //mandamos la info correspondiente para registrar la imagen en nuestra carpeta
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
        $count = 0;
        $dataFilter = null;
        $data = $this->model->getUsers($_POST["filter"]);
        if (is_array($data)) {
            $array = $data['results'];
            foreach ($array as $key => $value) {
                $dataUser = json_encode($array[$count]);
                $dataFilter .= "<tr>".
                "<td>".$value["NID"]."</td>".
                "<td>".$value["Nombre"]."</td>".
                "<td>".$value["Usuario"]."</td>".
                "<td>".$value["Roles"]."</td>".
                "<td>".
                "<a href='#modal1'  onclick='dataUser(".$dataUser .")' class='btn modal-trigger'>Edit</a> | ".
                
                "<a href='#modal2' onclick='deleteUser(".$dataUser .")' class='btn red lighten-1 modal-trigger'>Delete</a>".
                "</td>". 
                "</tr>";
                $count++;

            }
            echo $dataFilter;
        } else {
            echo $data;
        }
        
    }
    public function editUser(){
        $archivo = null;
        $tipo = null;
        $imagen = null;
        if (isset($_FILES['file'])) {//verificamos si hemos seleccionado alguna imagen
            $tipo = $_FILES['file']["type"];//para poder actualizarla
            $archivo = $_FILES['file']["tmp_name"];
            $imagen = $this->image->cargar_imagen($tipo,$archivo,$_POST["email"],"usuarios");//solo cargara este metodo si es por HTTP o post
        }else{
        if (isset($_POST['imagen'])) {//comprobamos si esta definida o sea si esta pasando
            $imagen = $_POST['imagen'].".png";
        }
        }
        $response = $this->model->getUser($_POST["idUsuario"]);
        if(is_array($response)){//verifiamos si es un arreglo el que se ha devuelto
            $array = array(//este array contendra todas las variables que capturemos con tipo post
                $_POST["nid"],$_POST["nombre"],$_POST["apellido"],$_POST["telefono"],$_POST["email"],$response[0]['Password'],$_POST["usuario"],$_POST["role"],$imagen
                        );
                    echo $this->model->editUser($this->userClass($array),$_POST["idUsuario"]);//User class retorna la instancia de una clase anonima con toda
                   //la info del usuario
                }else{

        }
        
    
    }
    public function deleteUser(){
        echo $this->model->deleteUser($_POST["idUsuario"],$_POST["email"]);//mandamos la info al modelo
    }
public function destroySession(){
    Session::destroy();
    header("Location:".URL);//url es una constante que direccion al index
}
}

?>