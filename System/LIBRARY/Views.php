<?php
class Views 
{
    function render($controller,$view,$models){
       //echo $controller;
     
        $controllers = get_class($controller);
       
        require VIEWS.DFT."head.html";
        if($models==null){
//archivos de cabezera para cargar las vistas
        require VIEWS.$controllers.'/'.$view.'.html';//carpetas con nombre de controladores con las pistas
        }else{
            require VIEWS.$controllers.'/'.$view.'.php';
        }
        require VIEWS.DFT."footer.html";
    }
}

?>