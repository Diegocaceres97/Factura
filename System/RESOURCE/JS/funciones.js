var validarEmail =(email)=>{
    let regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    if(regex.test(email)){
        return true;
    }else{
        return false;
    }
}
//capturando correo electronico por JS (lado del cliente)
var getParameterByName=(name)=>{
//el metodo replace() busca una cadena para un valor especifico, o una expresion regular,
//y devuelve una cadena donde se reemplazan los valores especificos
    name = name.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");
    //esa EXPRESION REGULAR (RegExp) encuentra un texto de acuerdo a una expresion
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    //esta funcion decodifica un componente url
return results == null ? null : decodeURIComponent(results[1].replace(/\+/g," "));
}
var printThisDiv = (id) =>{
    var printContents=document.getElementById(id).innerHTML;
    var originalContents = document.body.innerHTML;//obtenemos todo el contenido
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents; 
}