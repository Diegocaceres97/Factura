<?php
class Views 
{
    function render($controller,$view){
       //echo $controller;
       if($controller != "question"){
        $controllers = get_class($controller);
       }else{
        $controllers = $controller;
       }
        require VIEWS.DFT."head.html";
//archivos de cabezera para cargar las vistas
        require VIEWS.$controllers.'/'.$view.'.html';//carpetas con nombre de controladores con las pistas

        require VIEWS.DFT."footer.html";
    }
}

?>