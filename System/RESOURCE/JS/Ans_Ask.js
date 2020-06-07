class Ans_Ask{
    constructor() { 
        this.Funcion = 0; //Creamos propiedades    
        this.Pregunta=null;
    }
registerAsk(){  
    let valor = false;
//alert(this.Pregunta);
var data = new FormData();
                var url = this.Funcion == 0 ? "AskQ/registerA" : "AskQ/editAsk";//terniaria (comparacion)
                let roles = document.getElementById("sp");
                let role = roles.options[roles.selectedIndex].text;
                data.append('ask',document.getElementById("ask").value);
                data.append('ans', document.getElementById("ans").value);
                data.append('ansd', document.getElementById("ansd").value);
                data.append('anst', document.getElementById("anst").value);      
                data.append('sp', role); 
                data.append('pv',this.Pregunta);
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
                            alert("PROCESO EXITOSO");
                        } else {
                            valor=true;
                            document.getElementById("registerMessageD").innerHTML = response;//se envia la respuesta al label html
                        }
                    }
                });

                return valor;
}
reestablerAsk(){
    this.Funcion = 0;
   // preguntavieja = null;
    var instance = M.Modal.getInstance($('#modal3'));
        instance.close();
document.getElementById("ask").value="";
document.getElementById("ans").value="";
document.getElementById("ansd").value="";
document.getElementById("anst").value="";
window.location.href = URL + "Principal/principal";

}
getAsk(valor, page) {
    //alert(valor);
    var valor = valor != null ? valor : ""; //operador terniario donde deveulve true o false dependiendo el parametro valor que devuelve 
    $.post(
        URL + "AskQ/getAsk",//le enviamos los datos al servidor
        {
            filter: valor,
            page: page
        },
        (response) => {
            // $("#resultUser").html(response);//el dato que capturemos del servidor lo mandaremos a resultuser
            //el resultUser es el BODY de la tabla
            try {
                let item = JSON.parse(response);
                $("#resultP").html(item.dataFilter);
                $("#paginadorP").html(item.paginador);
                console.log(item);
            } catch (error) {
                $("#paginadorP").html(response);
            }

        }
    );
}
deleteAsk(data) {
    // alert(data.Pregunta);
     $.post(//enviamos los datos por post       
         URL + "AskQ/deleteAsk",
         {
             pregunta: data.Pregunta
         },
         (response) => {
             if (response == 0) {
                document.getElementById("deteUserMessageT").innerHTML = response;
                 this.reestablerAsk();
             } else {
                 document.getElementById("deteUserMessageT").innerHTML = response;
             }
             console.log(response);
         }
     );
 }
 editAsk(data) {//metodo donde obtendremos los datos seleccionados
    this.Funcion = 1;//con esto capturaremos la informacion necesaria para registrar usuario
    this.Pregunta = data.IdPregunta;
   // preguntavieja = document.getElementById("ask").value;
    document.getElementById("ask").value = data.Pregunta;//dejaremos las entradas en blanco para cuando acabemos de resgistrar
    document.getElementById("ans").value = data.R1;
    document.getElementById("ansd").value = data.R2;
    document.getElementById("anst").value = data.R3;
    document.getElementById("sp").value=data.RP;
    $('select').formSelect();
}

}