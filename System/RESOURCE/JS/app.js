var data_User = null;

var Usuarios = new usuarios();

var principal = new Principal();
var loginUser =() =>{ //Variable funcion fantasma   
Usuarios.loginUser();

}
var sessionClose=() =>{
    Usuarios.sessionClose();
}
var restablecerUser = () =>{
    Usuarios.restablecerUser();
}
var archivo = (evt) =>{
    //obtenemos los elementos que hemos obtenido del imput file en la clase usuario
    return Usuarios.archivo(evt,"fotos");
}
var getRoles = () =>{
    Usuarios.getRoles(null,1);
}
$(function(){//capturamos la funcion del evento Usuarios.html al momento de registrar
$("#registerUser").click(function(){
Usuarios.registerUser();
});
$("#registerClose").click(function(){
Usuarios.restablecerUser();
});
$("#deleteUser").click(function(){
    Usuarios.deleteUser(data_User);
    data_User=null;
    });
});
var getUsers = (page) =>{
    let valor = document.getElementById("filtrarUser").value;
    Usuarios.getUsers(valor,page);
}
var dataUser = (data)=>{
Usuarios.editUser(data);
}
var deleteUser = (data) =>{
    document.getElementById("userName").innerHTML = data.Email;
    data_User = data;
}

//Clientes
var cliente = new Clientes();
$(function(){
$("#registerCliente").click(function(){//capturamos el evento click del elemento
 return cliente.registerCliente();   
});
$("#clienteClose").click(function(){//capturamos el evento click del elemento
    return cliente.restablecerClientes();   
   });
});
var getCreditos = () =>{
    cliente.getCreditos();
}
var fotoCliente = (evt) =>{
    //obtenemos los elementos que hemos obtenido del imput file en la clase usuario
     cliente.archivo(evt,"fotoCliente");
}

//Anonimo
$().ready(()=>{
    let URLactual = window.location.pathname;//variable local con la que capturaremos lo que pase por el URL
    Usuarios.userData(URLactual);//creamos metodo en la clase usuarios
    principal.linkprincipal(URLactual);
    //inicializamos controles que nos proporciona el framework materialize
$("#validate").validate();
$("#validated").validate();
/*$('.sidenav').sidenav();//inicializamos el side nav para el slide-out movil desplegable
$('.modal').modal();
$('select').formSelect();*/
M.AutoInit();//con esta sola linea de codigo inicializamos todo los controles
});