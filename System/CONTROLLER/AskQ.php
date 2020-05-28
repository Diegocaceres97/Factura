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
}
?>