class Ans_Ask{
    constructor() { 
        this.Funcion = 0; //Creamos propiedades    

    }
registerAsk(){  
    let valor = false;
alert("Entra por acá");
var data = new FormData();
                var url = this.Funcion == 0 ? "AskQ/registerA" : "AskQ/editA";//terniaria (comparacion)
                let roles = document.getElementById("sp");
                let role = roles.options[roles.selectedIndex].text;
                data.append('ask', document.getElementById("ask").value);
                data.append('ans', document.getElementById("ans").value);
                data.append('ansd', document.getElementById("ansd").value);
                data.append('anst', document.getElementById("anst").value);      
                data.append('sp', role);    
                $.ajax({
                    url: URL + url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: (response) => {//esta propiedad contendra la funcion que va obtener la info que devuelva el servidor
                        if (response == 0) {                                                     
                            //  location.reload();//recargamos la pagína para que se vea el registro al instante
                            reestablerAsk();
                            alert("REGISTRO EXITOSO");
                        } else {
                            valor=true;
                            document.getElementById("registerMessageD").innerHTML = response;//se envia la respuesta al label html
                        }
                    }
                });
                return valor;
}
reestablerAsk(){
    var instance = M.Modal.getInstance($('#modal3'));
        instance.close();
document.getElementById("ask").value="";
document.getElementById("ans").value="";
document.getElementById("ansd").value="";
document.getElementById("anst").value="";
     //    window.location.href = URL + "Principal/principal";

}
}