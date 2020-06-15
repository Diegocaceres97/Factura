<?php
class AskQ extends Controllers{
    function __construct(){
        parent::__construct();//Se invoca al metodo controlador (__contruct) de la clase controller     
    }
public function registerA(){
    $array = array(
        $_POST["ask"],$_POST["ans"],$_POST["ansd"],$_POST["anst"],$_POST["sp"]); 
                
                $data = $this->model->registerA($array);
}
public function getAsk(){
    $user = Session::getSession("User");//verificamos que sea un usuario logeado como metodo de seguridad
    if(null != $user){
        $count = 0;
        $dataFilter = null;
        if($_POST["page"]==0){
            $data = $this->model->getAsk($_POST["filter"],$_POST["page"],$this->page);
            if (is_array($data)) {
                $array = $data['results'];
                echo $array=json_encode($array);
            }
        }else{
        $data = $this->model->getAsk($_POST["filter"],$_POST["page"],$this->page);
        if (is_array($data)) {
            $array = $data['results'];
            foreach ($array as $key => $value) {
                $dataUser = json_encode($array[$count]);
                
                $dataFilter .= "<tr>".
                "<td>".$value["Pregunta"]."</td>".
                "<td>".$value["R1"]."</td>".
                "<td>".$value["R2"]."</td>".
                "<td>".$value["R3"]."</td>".
                "<td>".
                "<a href='#modal3'  onclick='dataAsk(".$dataUser .")' class='btn modal-trigger'>Edit</a> | ".
                
                "<a href='#modal9' onclick='deleteAsk(".$dataUser .")' class='btn red lighten-1 modal-trigger'>Delete</a>".
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
}
public function otro(){
    echo "llego";
    $response = $this->model->getAsks($_POST["filter"]);
    if(is_array($data)){
        return $data;
    }else{
        return "error";
    }
}

public function deleteAsk(){
    $user = Session::getSession("User");
    if(null != $user){//verificamos la autorizacion del usuario comenzando por que sea uno
if ("Admin"==$user["Roles"]) {
    //echo "Hola".$_POST["ask"];
echo $this->model->deleteAsk($_POST["pregunta"]);//mandamos la info al modelo
}else{
echo "no tiene autorizacion";
}
}
    
}

/*function getAsk(){
    $data = $this->model->getAsk();//Obtenemos el resultado de la funcion en el model usuarios
    if(is_array($data)){
        echo json_encode($data);
    }else{
        echo $data;
    }
}*/
public function editAsk(){
    $user = Session::getSession("User");
    if(null != $user){//verificamos la autorizacion del usuario comenzando por que sea uno
if ("Admin"==$user["Roles"]) {
if(empty($_POST["ask"])){
echo "el campo ask es obligario";
}else{
    if(empty($_POST["ans"])){
        echo "el campo respuesta uno es obligario";
}else{
    if(empty($_POST["ansd"])){
        echo "el campo respuesta dos es obligario";
}else{
    if(empty($_POST["anst"])){
        echo "el campo respuesta tres es obligario";
}
$response = $this->model->getAsks($_POST["pv"]);
//echo $response;
if(is_array($response)){//verifiamos si es un arreglo el que se ha devuelto
    $array = array(//este array contendra todas las variables que capturemos con tipo post
        $_POST["ask"],$_POST["ans"],$_POST["ansd"],$_POST["anst"],$_POST["sp"]);
         echo $this->model->editAsk($array,$_POST["pv"]);//User class retorna la instancia de una clase anonima con toda
           //la info del usuario
        }
}} }}else {
echo "No tiene autorizacion";
}    
  /*  */
}
}
}
?>