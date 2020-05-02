class Principal{
    constructor(){

    }
    linkprincipal(link){
 
    switch (link) {
          
            case PATHNAME+"Principal/principal":
                document.getElementById("enlace1").classList.add('active');//con el metodo classlist
                //agregamos una clase a este elemento
                break;
        
                case PATHNAME+"Usuarios/usuarios":
                    document.getElementById("enlace2").classList.add('active');//con el metodo classlist
                    //agregamos una clase a este elemento
                    break;
        }
        
    }
}