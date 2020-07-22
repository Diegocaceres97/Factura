<?php
class Usuarios extends Controllers
{
    function __construct(){
        parent::__construct();//Se invoca al metodo controlador (__contruct) de la clase controller 
      
    }
    public function usuarios(){
        if (null != Session::getSession("User")){//comprobara si ha destruido datos de sesion
            $this->view->render($this,"usuarios",null); //invocamos el objeto render desde controllers
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
        $user = Session::getSession("User");
        if(null != $user){//verificamos la autorizacion del usuario comenzando por que sea uno
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
        if(empty($_POST["password"])){
            echo "el campo password es obligario";
    }else{
        if(6<=strlen($_POST["password"])){
if(empty($_POST["usuario"])){
echo "El campo usuario es necesario";
}else{
if (strcmp("seleccione un ROL",$_POST["role"])==0) {//comparamos dos cadenas de texto
   echo "seleccione un rol";
} else {
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

}
        }else{
            echo "ingrese una contraseña de 6 digitos o más";
        }
    }
}
}
}
} }else {
    echo "No tiene autorizacion";
}    
      /*  */
    }}
    public function getUsers(){
        $user = Session::getSession("User");//verificamos que sea un usuario logeado como metodo de seguridad
        if(null != $user){
            $count = 0;
            $dataFilter = null;
            //obtenemos los usuarios solicitados por medio del metodo alojado en el modelo y mandandole estos 3 parametros
            $data = $this->model->getUsers($_POST["filter"],$_POST["page"],$this->page);
            if (is_array($data)) {
                //manejamos los datos devueltos
                $array = $data['results'];
                foreach ($array as $key => $value) {
                    $dataUser = json_encode($array[$count]);
                    $urlImage = URL."Resource/images/fotos/usuarios/".$value["Imagen"];
                    $dataFilter .= "<tr>".
                    "<td>".
                     
                    "<img width='80' height='60' src='".$urlImage."'/>".
                    "</td>".
                    "<td>".$value["Nombre"]."</td>".
                    "<td>".$value["Usuario"]."</td>".
                    "<td>".$value["Roles"]."</td>".
                    "<td>".
                    "<a href='#modal1'  onclick='dataUser(".$dataUser .")' class='btn modal-trigger'>Edit</a> | ".
                    
                    "<a href='#modal2' onclick='deleteUser(".$dataUser .")' class='btn red lighten-1 modal-trigger' >Delete</a>".
                    "</td>". 
                    "</tr>";
                    $count++;
    
                }
                $paginador = "</p> <p>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
                echo json_encode( array(//lo convertimos a json para que el codigo por el lado del cliente capture esta info y verla en vista usuario
                    "dataFilter" => $dataFilter,
                    "paginador" => $paginador
                ));
            } else {
                echo $data;
            }
            
        }
        
    }
    public function editUser(){
        $user = Session::getSession("User");
        if(null != $user){//verificamos la autorizacion del usuario comenzando por que sea uno
if ("Admin"==$user["Roles"]) {
    if(empty($_POST["nid"])){
echo "el campo nid es obligario";
    }else{
        if(empty($_POST["nombre"])){
            echo "el campo nombre es obligario";
    }else{
        if(empty($_POST["apellido"])){
            echo "el campo apellido es obligario";
    }else{
        if(empty($_POST["telefono"])){
            echo "el campo telefono es obligario";
    }else{
        if(empty($_POST["password"])){
            echo "el campo password es obligario";
    }else{
        if(6<=strlen($_POST["password"])){
if(empty($_POST["usuario"])){
echo "El campo usuario es necesario";
}else{
if (strcmp("seleccione un ROL",$_POST["role"])==0) {//comparamos dos cadenas de texto
   echo "seleccione un rol";
} else {
    
    $archivo = null;
    $tipo = null;
    $imagen = null;
    if (isset($_FILES['file'])) {//verificamos si hemos seleccionado alguna imagen
        $tipo = $_FILES['file']["type"];//para poder actualizarla
        $archivo = $_FILES['file']["tmp_name"];
        $imagen = $this->image->cargar_imagen($tipo,$archivo,$_POST["email"],"usuarios");//solo cargara este metodo si es por HTTP o post
        $cam = RQ."IMAGES/fotos/usuarios/".$_POST['imagen'];
        unlink($cam);//eliminamos la imagen anterior ya que ahora le estoy generando automaticamente un numero para que actualice
        $cam=null;//instantaneamente al actualizar esta
    }else{
    if (isset($_POST['imagen'])) {//comprobamos si esta definida o sea si esta pasando
        $archivo = $_POST['imagen'];
        $imagen = $this->image->cargar_imagen($tipo,$archivo,$_POST["email"],"usuarios");
        if ($_POST['imagen'] != $_POST["email"].".png") {//evaluamos si la imagen que obtiene por el post es la misma que al editar el email
            //del usuario en concreto, si pasa por acá quiere decir que esta actualizando el correo electronico
        $archivo = RQ."IMAGES/fotos/usuarios/".$_POST['imagen'];
        unlink($archivo);//eliminamos el archivo imagen que contenga el nombre anterior del usuario (imagen desactualizada)
        $archivo = null;
        } 
        
    }
    }
    $response = $this->model->getUser($_POST["idUsuario"]);
   //echo $response;
    if(is_array($response)){//verifiamos si es un arreglo el que se ha devuelto
        $array = array(//este array contendra todas las variables que capturemos con tipo post
            $_POST["nid"],$_POST["nombre"],$_POST["apellido"],$_POST["telefono"],$_POST["email"],$response[0]['Password'],$_POST["usuario"],$_POST["role"],$imagen
                    );
                echo $this->model->editUser($this->userClass($array),$_POST["idUsuario"]);//User class retorna la instancia de una clase anonima con toda
               //la info del usuario
            }else{

    }
}

}
        }else{
            echo "ingrese una contraseña de 6 digitos o más";
        }
    }
}
}
}
} }else {
    echo "No tiene autorizacion";
}    
      /*  */
    }
    }
    public function deleteUser(){
        $user = Session::getSession("User");
        if(null != $user){//verificamos la autorizacion del usuario comenzando por que sea uno
if ("Admin"==$user["Roles"]) {
    echo $this->model->deleteUser($_POST["idUsuario"],$_POST["Imagen"]);//mandamos la info al modelo
}else{
    echo "no tiene autorizacion";
}
}
        
    }
public function destroySession(){
    Session::destroy();
    header("Location:".URL);//url es una constante que direccion al index
}
}

?>