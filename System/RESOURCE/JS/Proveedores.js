class Proveedores extends Uploadpicture{
    constructor(){
        super();
        this.Funcion = 0;
        this.IdProveedor = 0;
        this.Imagen = null;
    }
    registerProve(){
        var data = new FormData(); //creamos una coleccion de objetos para enviarlos al servidor
        $.each($("input[type=file")[0].files, (i, file) => {
          data.append("file", file);
        });
        var url =
        this.Funcion == 0 ? "Proveedores/registerProve" : "Proveedores/editProve";
        data.append("idProveedor", this.IdProveedor);
        data.append("proveedor", document.getElementById("proveedor").value);
        data.append("telefono", document.getElementById("telefono").value);
        data.append("email", document.getElementById("email").value);
        data.append("direccion", document.getElementById("direccion").value);
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
              if (response==0) {
                this.restablecerProveedores();
              } else {
                document.getElementById("MessageProveedor").innerHTML=response;
              }
            console.log(response);
            },
          });
          return false;
    }
    getProveedores(page) {
      $.post(
        URL + "Proveedores/getProveedores",
        { search: $("#searchProveedores").val(), page: page },
        (response) => {
          console.log(response);
          try {
            let item = JSON.parse(response);
            $("#resultProveedores").html(item.dataFilter); //nombre de las propiedades item de Clientes.php obtenidas en la funcion
            $("#paginadorProveedores").html(item.paginador);
            //console.log(item);
          } catch (error) {
            $("#paginadorProveedores").html(response);
          }
        }
      );
    }
    restablecerProveedores(){
      this.Funcion = 0;
        this.IdProveedor = 0;
        this.Imagen = null;
      window.location.href = URL + "Proveedores/proveedores";
    }
    dataProveedor(email){
      $.post(
        URL + "Proveedores/dataProveedor",
        { email: email },
        (response) => {
          switch(response){
            case "1":
              window.location.href = URL;
              break;
              case "2":
                window.location.href = URL + "Proveedores/proveedores";
                break;
              default:
                try {
                  let item =JSON.parse(response);
                  this.Funcion=1;
                  this.IdProveedor = item.results[0].IdProveedor;
                  this.Imagen = item.results[0].Email;
                  document.getElementById("fotoProveedor").innerHTML = [
                    '<img class="responsive-img " src="',
                    URL + FOTOS + "proveedores/" + item.results[0].Email+".png",
                    '" title="',
                    escape(item.results[0].Email),
                    '"/>',
                  ].join("");
                  document.getElementById("proveedor").value = item.results[0].Proveedor; //dejaremos las entradas en blanco para cuando acabemos de resgistrar
                  document.getElementById("telefono").value = item.results[0].Telefono;
                  document.getElementById("email").value = item.results[0].Email;
                  document.getElementById("direccion").value = item.results[0].Direccion;
                } catch (error) {
                  $('MessageProveedor').html("MAL");
                }
                break;
          }
          console.log(response);
        }
        );
    }
    getReportePro(email){
      $.post(
        //Mandamos por post al backend  o parte del servidor
        URL + "Proveedores/getReporteProve",
        { email: email },
        (response) => {
         console.log(response);
           try {
            let item = JSON.parse(response);
            //console.log(item);
            if (0 != item.data) {
              $("#proveedorNombre").html(item.array.Nombre);
              document.getElementById("proveedorReporte").innerHTML = [
                '<img class="responsive-img valign profile-image img" src="',
                URL + FOTOS + "proveedores/" + item.array.Email + ".png",
                '"title="',
                escape(item.array.Email),
                '"/>',
              ].join("");
              $("#deuda").html(item.array.Deuda);
              $("#fechadeuda").html(item.array.FechaDeuda);
              $("#pago").html(item.array.Pago);
              $("#fechapago").html(item.array.FechaPago);
              $("#ticket").html(item.array.Ticket);
              $("#proveedorNombre").html(
                "Proveedor: " + item.array.Proveedor
              );
              $("#deudas").html(item.array.Deuda);
              localStorage.setItem("reportProveedor", response);
            } else {
              window.location.href = URL + "Proveedores/proveedor";
            }
          } catch (error) {
            $("#reporteProveedorMessage").html(response);
          }
        }
      );
    }
    setPagos(){
     
       $.post(
         URL + "Proveedores/setPagos",
         {
           pagos: $("#pagos").val()
         },
         (response) =>{
           console.log(response);
           /*if (response==0) {
             let proveedor = JSON.parse(localStorage.getItem("reportProveedor"));
          this.getReportePro(Proveedor.array.Email);
            } else {
             $("#pagoProveedor").html(response);
           }*/
         }
       );
     return false;
    }
}