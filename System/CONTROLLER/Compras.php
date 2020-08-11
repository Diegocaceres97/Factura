<?php
class Compras extends Controllers
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
    }else{
        header("Location:".URL);
    }
        
    }
}

?>