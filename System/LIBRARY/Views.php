<?php
class Views 
{
    function render($controller,$view){
       //echo $controller;
     
        $controllers = get_class($controller);
       
        require VIEWS.DFT."head.html";
//archivos de cabezera para cargar las vistas
        require VIEWS.$controllers.'/'.$view.'.html';//carpetas con nombre de controladores con las pistas

        require VIEWS.DFT."footer.html";
    }
}

?>