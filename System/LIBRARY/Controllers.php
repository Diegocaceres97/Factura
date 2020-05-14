<?php
class Controllers extends Anonymous
{
    public function __construct() {
        Session::star();//invocamos a los metodos estaticos que tenemos en Session 
        $this -> view = new Views(); //Instanciamos a view (invocamos)
        $this->image = new Uploadimage();
        $this->page=new Paginador();
        $this->loadClassModels();
    }
    function loadClassModels(){
       // echo "primero";
        $model = get_class($this).'_model';//Concatenamos y mandamos la peticion
        $path = 'MODEL/'.$model.'.php';//verificamos si existe
        if(file_exists($path)){//creamos la instancia
            require $path;// y la obtenemos o requerimos
            $this -> model = new $model(); //Creamos una instancia tipo model
        }
    }
}

?>