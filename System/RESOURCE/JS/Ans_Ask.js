class Ans_Ask {
  constructor() {
    this.Funcion = 0; //Creamos propiedades
    this.Pregunta = null;
  }
  registerAsk() {
    let valor = false;
    //alert(this.Pregunta);
    var data = new FormData();
    var url = this.Funcion == 0 ? "AskQ/registerA" : "AskQ/editAsk"; //terniaria (comparacion)
    let roles = document.getElementById("sp");
    let role = roles.options[roles.selectedIndex].text;
    if(role=="R1"){
      role=0;
    }else if(role=="R2"){
      role=1;
    }else if(role=="R3"){
      role=2;
    }
    data.append("ask", document.getElementById("ask").value);
    data.append("ans", document.getElementById("ans").value);
    data.append("ansd", document.getElementById("ansd").value);
    data.append("anst", document.getElementById("anst").value);
    data.append("sp", role);
    data.append("pv", this.Pregunta);
    $.ajax({
      url: URL + url,
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      type: "POST",
      success: (response) => {
        //esta propiedad contendra la funcion que va obtener la info que devuelva el servidor
        if (response == 0) {
          //  location.reload();//recargamos la pagína para que se vea el registro al instante
          reestablerAsk();
          alert("PROCESO EXITOSO");
        } else {
          valor = true;
          document.getElementById("registerMessageD").innerHTML = response; //se envia la respuesta al label html
        }
      },
    });

    return valor;
  }
  reestablerAsk() {
    this.Funcion = 0;
    // preguntavieja = null;
    var instance = M.Modal.getInstance($("#modal3"));
    instance.close();
    document.getElementById("ask").value = "";
    document.getElementById("ans").value = "";
    document.getElementById("ansd").value = "";
    document.getElementById("anst").value = "";
    window.location.href = URL + "Principal/principal";
  }
  getAsk(valor, page) {
    // alert(page);
    var valor = valor != null ? valor : ""; //operador terniario donde deveulve true o false dependiendo el parametro valor que devuelve
    $.post(
      URL + "AskQ/getAsk", //le enviamos los datos al servidor
      {
        filter: valor,
        page: page,
      },
      (response) => {
        // $("#resultUser").html(response);//el dato que capturemos del servidor lo mandaremos a resultuser
        //el resultUser es el BODY de la tabla
        try {
          let item = JSON.parse(response);
          if (page == 0) {
            var res = [];
            //convertimos de formato JSON a formato array JS
            for (var i in item) {
              res.push(item[i]);//pasamos el JSON {} a un array (objeto) nativo de JS
            }
            var y = [];//array de apoyo
            //delete res['IdPregunta'];
            for (var t = 0; t < res.length; t++) {//recorremos el array recien convertido
              var h = res[t];//lo recorremos uno por uno en la posicion indicada en una nueva variable que almacenara solo el subarray
              //que es la pregunta independiente
              delete h["IdPregunta"];//borramos de esa pregunta (subarray) el elemento key que se llame IdPregunta con su valor 
              y.push(h);//puchamos al array de apoyo
              //return y;
            }
            console.log(y); 
          
          } else {
            $("#resultP").html(item.dataFilter);
            $("#paginadorP").html(item.paginador);
            console.log(item);
          }
        } catch (error) {
          $("#paginadorP").html(response);
        }
      }
    );
  }

  deleteAsk(data) {
    // alert(data.Pregunta);
    $.post(
      //enviamos los datos por post
      URL + "AskQ/deleteAsk",
      {
        pregunta: data.Pregunta,
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
  editAsk(data) {
    //metodo donde obtendremos los datos seleccionados
    this.Funcion = 1; //con esto capturaremos la informacion necesaria para registrar usuario
    this.Pregunta = data.IdPregunta;
    // preguntavieja = document.getElementById("ask").value;
    document.getElementById("ask").value = data.Pregunta; //dejaremos las entradas en blanco para cuando acabemos de resgistrar
    document.getElementById("ans").value = data.R1;
    document.getElementById("ansd").value = data.R2;
    document.getElementById("anst").value = data.R3;
    if(data.RP=="0"){
      document.getElementById("sp").value ="R1";
    }
    if(data.RP=="1"){
      document.getElementById("sp").value ="R2";
    }
    if(data.RP=="2"){
      document.getElementById("sp").value ="R3";
    }
    $("select").formSelect();
  }
  getAskD() {
    var valor = null; //operador terniario donde deveulve true o false dependiendo el parametro valor que devuelve
    $.post(
      URL + "AskQ/otro", //le enviamos los datos al servidor
      {
        filter: valor,
      },
      (response) => {
        // $("#resultUser").html(response);//el dato que capturemos del servidor lo mandaremos a resultuser
        //el resultUser es el BODY de la tabla
        try {
          let item = JSON.parse(response);
          alert(item);
        } catch (error) {
          alert(item);
        }
      }
    );
  }
  
}
