<?php
class Principal extends Controllers{
    function __construct(){
        parent::__construct();
    }
    public function principal(){
        if (null != Session::getSession("User")){//comprobara si ha destruido datos de sesion
            $this->view->render($this,"principal"); //invocamos el objeto render desde controllers
        } else {//asi evitamos que entre despés de salido
            header("Location:".URL);
        }
        

    }
}


?>