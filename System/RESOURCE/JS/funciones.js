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
var getFechas = () =>{
    var now = new Date();
    var day = ("0"+now.getDate()).slice(-2);
    var month = ("0"+(now.getMonth() + 1)).slice(-2);
    today = (day)+"/"+ (month) + "/" +now.getFullYear();
    return today;
}
var filterFloat = (evt,input)=>{
    //Backspace = 8, Enter = 13, '0' = 48, '9' = 57, '.' = 46, '-' = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if (key >= 48 && key <= 57) {
        if (filter(tempValue)==false) {
            return false;
        }else{
            return true;
        }
    }else{
        if(key == 8||key ==13||key==0){
            return true; 
        }else if(key ==46 || key ==44){
if(filter(tempValue)==false){
return false;
}else{
    return true;
}
        }else{
            return false;
        }
    }
}
var filter = (_val_) =>{
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    if(preg.test(_val_)){//test devuelve un booleano
return true;
    }else{
return false;
    }
}
var numberDecimales = (number) =>{
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",");
}