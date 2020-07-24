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
      this.Funcion == 0 ? "Clientes/registerCliente" : "Usuarios/editCliente";
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
            this.restablecerClientes();
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
    }return valor;
  }
  restablecerClientes(){
    document.getElementById("fotoCliente").innerHTML = [
        '<img class="responsive-img" src="',
        URL + "RESOURCE/IMAGES/fotos/clientes/default.png",
        '"title="',
        ,
        '"/>',
      ].join("");
      window.location.href = URL + "Clientes/clientes";
  }
  getCreditos(){
    $.post(
      URL+"Clientes/getCreditos",
      {},
      (response) =>{
        try {
          let item = JSON.parse(response);//convertimos el tipo Json en una coleccion de objetos
          console.log(item);
          if(0<item.results.length){
for(let i=0;i<item.results.length;i++){
document.getElementById('creditos').options[i] = new Option(item.results[i].Creditos, item.results[i].IdCreditos);
$('select').formSelect();//inicializamos nuestro control de tipo select
}}
        } catch (error) {
          document.getElementById('clienteMessage').innerHTML=response;
        }
      }
    );
  }
  getClientes(page){
    $.post(
      URL + "Clientes/getClientes",
      {search:$("#filtrarCliente").val(),page:page},
      (response)=>{
        console.log(response);
        try {
          let item=JSON.parse(response);
          $("#resultCliente").html(item.dataFilter);//nombre de las propiedades item de Clientes.php obtenidas en la funcion
          $("#paginadorCliente").html(item.paginador);
          console.log(item);
        } catch (error) {
          $("#paginadorCliente").html(response);
        }
      }
    );
  }
  getReporteCliente(email){
    $.post(//Mandamos por post al backend  o parte del servidor
      URL + "Clientes/getReporteCliente",
      {email: email},
      (response)=>{
        console.log(response);
        try {
          let item = JSON.parse(response);
          console.log(item);
          if (0!=item.data) {
            $("#ClienteNombre").html(item.array.Nombre);
            $("#clienteApellido").html(item.array.Apellido);
            document.getElementById("clienteReporte").innerHTML = ['<img class="responsive-img valign profile-image img" src="',URL + FOTOS +
          "clientes/"+item.array.Email+".png", '"title="', escape(item.array.Email), '"/>'].join('');
          $("#deuda").html(item.array.Deuda);
          $("#fechadeuda").html(item.array.FechaDeuda);
          $("#pago").html(item.array.Pago);
          $("#fechapago").html(item.array.FechaPago);
          $("#ticket").html(item.array.Ticket);
          $("#clienteNombres").html("Cliente: " + item.array.Nombre+" "+item.array.Apellido);
          $("#deudas").html(item.array.Deuda);
          localStorage.setItem("reportCliente", response);
          } else {
            window.location.href= URL + "Clientes/clientes";
          }
        } catch (error) {
          $("#reporteClienteMessage").html(response);
        }
      }
    );
  }
  setPagos(){
    if (null != localStorage.getItem("reportCliente")) {
    $.post(
      URL + "Clientes/setPagos",
      {pagos:$("#pagos").val()
    },
(response)=>{
  console.log(response);
  if (response==0) {
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
}
