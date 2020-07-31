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
        echo $_POST["proveedor"];
    }
}

?>