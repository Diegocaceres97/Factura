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
var pageTickets = 0;
var pageClientes = 0;
var cliente = new Clientes();
$(function(){
$("#registerCliente").click(function(){//capturamos el evento click del elemento
 return cliente.registerCliente();   
});
$("#clienteClose").click(function(){//capturamos el evento click del elemento
    return cliente.restablecerClientes(1);   
   });
});
var getCreditos = () =>{
    cliente.getCreditos(null,1);
}
var fotoCliente = (evt) =>{
    //obtenemos los elementos que hemos obtenido del imput file en la clase usuario
     cliente.archivo(evt,"fotoCliente");
}
var getClientes = (page) =>{
    pageClientes = page;
    cliente.getClientes(page);
}
var dataCliente=(data)=>{
    cliente.getCliente(data);
}
var getTickets = (page) =>{
    pageTickets = page;
    cliente.getTickets(page);
}
var exportarTicketClientes = ()=>{
    cliente.exportarExcel(pageTickets,1);
}
var exportarClientes = ()=>{
    cliente.exportarExcel(pageClientes,2);
}
//Proveedores
var pageTicketsp = 0;
var pageProveedor = 0;
var proveedores = new Proveedores();
$(function(){//capturamos la funcion del evento Usuarios.html al momento de registrar
    $("#registerProve").click(function(){
    return proveedores.registerProve();
    });
    });
    var fotoProveedor = (evt) =>{
        //obtenemos los elementos que hemos obtenido del imput file en la clase usuario
         proveedores.archivo(evt,"fotoProveedor");
    }
    var getProveedores =(page)=>{
        pageProveedor = page;
        proveedores.getProveedores(page);
    }
    var dataProveedor = (email)=>{
        proveedores.dataProveedor(email);
    }
    var getPtickets = (page) =>{
        pageTicketsp = page;
        proveedores.getTickets(page);
    }
    var exportarTicketProveedores = () =>{
        proveedores.exportarExcel(pageTicketsp,1);
    }
    //Compras de productos
    var compras = new Compras();
    var imageCompras = (evt)=>{
        compras.archivo(evt, "imageCompras");
    }
    var getCompraProveedores = (page) =>{
compras.getCompraProveedores(page);
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