
var Usuarios = new usuarios();
var loginUser =() =>{ //Variable funcion fantasma
    var email = document.getElementById("email").value;
    var pass = document.getElementById("password").value;
Usuarios.loginUser(email,pass);
}
var sessionClose=() =>{
    Usuarios.sessionClose();
}
var restablecerUser = () =>{
    Usuarios.restablecerUser();
}
var archivo = (evt) =>{
    //obtenemos los elementos que hemos obtenido del imput file en la clase usuario
    Usuarios.archivo(evt);
}

$(function(){//capturamos la funcion del evento Usuarios.html al momento de registrar
$("#btnLogn").click(function(){
    let nombre = document.getElementById("nombre").value;
    let apellido = document.getElementById("apellido").value;
    let nid = document.getElementById("nid").value;
    let telefono = document.getElementById("telefono").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let user = document.getElementById("usuario").value;
    let roles = document.getElementById("roles");
    let role = roles.options[roles.selectedIndex].text;
    if (role != "seleccione un ROL") {
    Usuarios.registerUser(nombre,apellido,nid,telefono,email,password,user,role);
    return false;//anulamos el evento onclick de nuestro btn y para no generar reenvio de formulario
    }
});
});
var principal = new Principal();
//Anonimo
$().ready(()=>{
    let URLactual = window.location.pathname;//variable local con la que capturaremos lo que pase por el URL
    Usuarios.userData(URLactual);//creamos metodo en la clase usuarios
    principal.linkprincipal(URLactual);
$("#validate").validate();
$('.sidenav').sidenav();//inicializamos el side nav para el slide-out movil desplegable
$('.modal').modal();
$('select').formSelect();
switch (URLactual) {
          
    case PATHNAME+"Principal/principal":
      
        break;

        case PATHNAME+"Usuarios/usuarios":
           document.getElementById('files').addEventListener('change',archivo, false);//le agregaremos un evento al imputfile en html usuarios
            break;
}
});