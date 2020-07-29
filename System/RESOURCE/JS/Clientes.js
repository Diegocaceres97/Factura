class Clientes extends Uploadpicture {
  constructor() {
    super();
    this.Funcion = 0;
    this.IdCliente = 0;
    this.Imagen = null;
  }
  registerCliente() {
    var valor = false;
    if (validarEmail($("#email").val())) {
      //capturamos el email del registro del cliente via JQuery
      var data = new FormData();
      $.each($("input[type=file")[0].files, (i, file) => {
        data.append("file", file);
      });
      var url =
        this.Funcion == 0 ? "Clientes/registerCliente" : "Clientes/editCliente";
      let creditos = document.getElementById("creditos");
      let role = creditos.options[creditos.selectedIndex].text;
      data.append("idCliente", this.IdCliente);
      data.append("nombre", document.getElementById("nombre").value);
      data.append("apellido", document.getElementById("apellido").value);
      data.append("nid", document.getElementById("nid").value);
      data.append("telefono", document.getElementById("telefono").value);
      data.append("email", document.getElementById("email").value);
      data.append("direccion", document.getElementById("direccion").value);
      data.append("creditos", role);
      data.append("imagen", this.Imagen);
      $.ajax({
        //enviamos la información al servidor via ajax
        url: URL + url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        success: (response) => {
          //esta propiedad contendra la funcion que va obtener la info que devuelva el servidor
          if (response == 0) {
            this.restablecerClientes(1);
            valor = false;
            //  location.reload();//recargamos la pagína para que se vea el registro al instante
            alert("PROCESO EXITOSO");
          } else {
            valor = true;
            document.getElementById("clienteMessage").innerHTML = response; //se envia la respuesta al label html
          }
        },
      });
    } else {
      document.getElementById("email").focus();
      document.getElementById("clienteMessage").innerHTML =
        "ingrese una direccion de correo valida";
      valor = true;
    }
    return valor;
  }
  restablecerClientes(funcion) {
    document.getElementById("fotoCliente").innerHTML = [
      '<img class="responsive-img" src="',
      URL + "RESOURCE/IMAGES/fotos/clientes/default.png",
      '"title="',
      ,
      '"/>',
    ].join("");
    switch (funcion) {
      case 1:
        window.location.href = URL + "Clientes/clientes";
        break;
    
      case 2:
        document.getElementById("nombre").value = ""; //dejaremos las entradas en blanco para cuando acabemos de resgistrar
    document.getElementById("apellido").value = "";
    document.getElementById("nid").value = "";
    document.getElementById("telefono").value = "";
    document.getElementById("email").value = "";
    document.getElementById("direccion").value = "";
    this.getCreditos(null, 1);
        break;
    }
    
  }
  getCreditos(credito,funcion) {

    $.post(URL + "Clientes/getCreditos", {}, (response) => {
      try {
        let item = JSON.parse(response); //convertimos el tipo Json en una coleccion de objetos
      //  console.log(item);
        if (0 < item.results.length) {
          for (let i = 0; i < item.results.length; i++) {
            switch (funcion) {
              case 1:
                document.getElementById("creditos").options[i] = new Option(
                  item.results[i].Creditos,
                  item.results[i].IdCreditos
                );
                $("select").formSelect(); //inicializamos nuestro control de tipo select
                break;
            
              case 2:
                document.getElementById("creditos").options[i] = new Option(
                  item.results[i].Creditos,
                  item.results[i].IdCreditos
                );
                if (item.results[i].Creditos==credito) {
                 // i++;
                  document.getElementById('creditos').selectedIndex = i;
                  //i--;
                }
                $("select").formSelect();
                break;
            }
           
          }
        }
      } catch (error) {
        document.getElementById("clienteMessage").innerHTML = response;
      }
    });
  }
  getClientes(page) {
    $.post(
      URL + "Clientes/getClientes",
      { search: $("#filtrarCliente").val(), page: page },
      (response) => {
        //console.log(response);
        try {
          let item = JSON.parse(response);
          $("#resultCliente").html(item.dataFilter); //nombre de las propiedades item de Clientes.php obtenidas en la funcion
          $("#paginadorCliente").html(item.paginador);
          //console.log(item);
        } catch (error) {
          $("#paginadorCliente").html(response);
        }
      }
    );
  }
  getReporteCliente(email) {
    $.post(
      //Mandamos por post al backend  o parte del servidor
      URL + "Clientes/getReporteCliente",
      { email: email },
      (response) => {
        //console.log(response);
        try {
          let item = JSON.parse(response);
          //console.log(item);
          if (0 != item.data) {
            $("#ClienteNombre").html(item.array.Nombre);
            $("#clienteApellido").html(item.array.Apellido);
            document.getElementById("clienteReporte").innerHTML = [
              '<img class="responsive-img valign profile-image img" src="',
              URL + FOTOS + "clientes/" + item.array.Email + ".png",
              '"title="',
              escape(item.array.Email),
              '"/>',
            ].join("");
            $("#deuda").html(item.array.Deuda);
            $("#fechadeuda").html(item.array.FechaDeuda);
            $("#pago").html(item.array.Pago);
            $("#fechapago").html(item.array.FechaPago);
            $("#ticket").html(item.array.Ticket);
            $("#clienteNombres").html(
              "Cliente: " + item.array.Nombre + " " + item.array.Apellido
            );
            $("#deudas").html(item.array.Deuda);
            let credito = parseFloat(item.array.Creditos.replace("$", ""));
            if (credito > 0) {
              document.getElementById("creditoCliente").innerHTML =
                "<span>Credito: <span class='green-text text-darken-3'>Activo</span></span>";
            } else {
              document.getElementById("creditoCliente").innerHTML =
                "<span>Credito: <span class='red-text text-darken-3'>No activo</span></span>";
            }
            localStorage.setItem("reportCliente", response);
          } else {
            window.location.href = URL + "Clientes/clientes";
          }
        } catch (error) {
          $("#reporteClienteMessage").html(response);
        }
      }
    );
  }
  setPagos() {
    if (null != localStorage.getItem("reportCliente")) {
      $.post(
        URL + "Clientes/setPagos",
        { pagos: $("#pagos").val() },
        (response) => {
         // console.log(response);
          if (response == 0) {
            let cliente = JSON.parse(localStorage.getItem("reportCliente"));

            this.getReporteCliente(cliente.array.Email);
          } else {
            $("#pagoCliente").html(response);
          }
        }
      );
    }
    return false;
  }
  getCliente(data){
    this.Funcion = 1;
    this.IdCliente = data.IdClientes;
    this.Imagen=data.Email;
    document.getElementById("fotoCliente").innerHTML = [
      '<img class="responsive-img " src="',
      URL + FOTOS + "clientes/" + data.Email+".png",
      '" title="',
      escape(data.Imagen),
      '"/>',
    ].join("");
    document.getElementById("nombre").value = data.Nombre; //dejaremos las entradas en blanco para cuando acabemos de resgistrar
    document.getElementById("apellido").value = data.Apellido;
    document.getElementById("nid").value = data.NID;
    document.getElementById("telefono").value = data.Telefono;
    document.getElementById("email").value = data.Email;
    document.getElementById("direccion").value = data.Direccion;
    //console.log(data);
    this.getCreditos(data.Creditos, 2);
  }
  getTickets(page){
    $.post(
      URL + "Clientes/getTickets",
      { search: $("#searchTicket").val(), page: page },
      (response) => {
        console.log(response);
        try {
          let item = JSON.parse(response);
          $("#resultTicket").html(item.dataFilter);
          $("#paginadorTicket").html(item.paginador);
          console.log(item);
        } catch (error) {
          $("#paginadorTicket").html(response);
        }
      }
    );
    }
    exportarExcel(page){
      $.post(
        URL + "Clientes/exportarExcel",
        { search: $("#searchTicket").val(), page: page },
        (response) => {
          console.log(response);
        }
      );
    }
  }

