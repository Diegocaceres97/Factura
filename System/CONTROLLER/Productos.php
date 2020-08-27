<?php
class Productos extends Controllers
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
    } 
}
public function getCompras(){
    $user = Session::getSession("User");//verificamos que sea un usuario logeado como metodo de seguridad
    if(null != $user){
        $count = 0;
        $dataFilter = null;
        //obtenemos los usuarios solicitados por medio del metodo alojado en el modelo y mandandole estos 3 parametros
        $data = $this->model->getCompra($_POST["search"],$_POST["page"],$this->page);
       //echo var_dump($data);
          if (is_array($data)) {
            //manejamos los datos devueltos
            $array = $data['results'];
            foreach ($array as $key => $value) {
                $dataCompra = json_encode($array[$count]);
                $urlImage = URL."Resource/images/fotos/Compras/".$value["Codigo"].".png";       
                $dataFilter .= "<tr>".
                "<td>".
                "<ul class='collection'>".
                 "<li class='collection-item avatar'>".
                "<img width='80' height='60'  src='".$urlImage."'/>
                </li>
                </ul>
                </td>".
                "<td>".$value["Descripcion"]."</td>".
                "<td>".$value["Precio"]."</td>".
                "<td>".
                "<a href='".URL."/Productos/registrar?IdTemp=".$value["IdTemp"]."' class='btn modal-trigger'>Registrar</a>".               
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
        }}}
        public function registrar(){
            $user = Session::getSession("User");//verificamos que sea un usuario logeado como metodo de seguridad
    if(null != $user){
        if("Admin"==$user["Roles"]){
            $this->view->render($this,"registrar",null);
        } else {
            header("Location:".URL."Principal/principal");
        }
    }
        }
    public function getProducto(){
        $user = Session::getSession("User");//verificamos que sea un usuario logeado como metodo de seguridad
        if(null != $user){
            if("Admin"==$user["Roles"]){
                $data = $this->model->getProducto($_POST["IdTemp"]);
                if (is_array($data)) {
                    echo json_encode($data);
                } else {
                    echo $data;
                }
            }
        }
    }
public function registrarProducto(){
    $user = Session::getSession("User");
    if(null != $user){
        if("Admin"==$user["Roles"]){
        if(empty($_POST["Descripcion"])){
            echo "el campo Descripcion es obligatorio";
        }else{
            if(empty($_POST["Precio"])){
                echo "el campo Precio es obligatorio";
            }else{
                if(empty($_POST["Departamento"])){
                    echo "el campo Departamento es obligatorio";
                }else{
                    if(empty($_POST["Categoria"])){
                        echo "el campo Categoria es obligatorio";
                    }else{
                        $codigoCompra = Session::getSession("compras_temp");
                        $img = file_get_contents(RQ."images/fotos/Compras/".$codigoCompra.".png");//con este metodo obtenemos una imagen dependiendo del directorio
                    //le proporcionamos la informacion a la clase anonima para poder manejarla de esa manera
                    $model = $this->TProductos(array(
                        $this->model->getCodigo(),//Obtenemos el codigo del producto
                        $_POST["Descripcion"],
                        "$".number_format($_POST["Precio"]),
                        $_POST["Departamento"],
                        $_POST["Categoria"],
                        "%0.00",
                        date("d"),
                        date("m"),
                        date("y"),
                        date("d/m/y"),
                        $codigoCompra,
                        base64_encode($img)//convertimos a base64 para poder almacenar nuestra imagen en la BD
                    ));
                    echo var_dump($model);
                    } 
                }
            }
        }
        }else{
echo "no tiene autorizacion";
        }
}
}
}

?>