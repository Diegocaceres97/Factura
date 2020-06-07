<?php
class Principal extends Controllers{
    function __construct(){
        parent::__construct();
    }
    public function principal(){
        if (null != Session::getSession("User")){//comprobara si ha destruido datos de sesion
            $user = Session::getSession("User");
            if ("Admin"==$user["Roles"]) {
            $this->view->render($this,"principal"); //invocamos el objeto render desde controllers
            }else{
                //$this->view->render("Preguntas","preguntas");
                $this->view->render("question","Question");
            }
        } else {//asi evitamos que entre despés de salido
            header("Location:".URL);
        }
        

    }
}


?>