class Compras extends Uploadpicture {
    constructor() {
      super();
      this.data=null;
    }
    getProveedores(page) {
        $.post(
          URL + "Compras/getProveedores",
          { search: $("#searchCompra").val(), page: page },
          (response) => {
            //console.log(response);
            try {
              let item = JSON.parse(response);
              $("#compraProveedores").html(item.dataFilter); //nombre de las propiedades item de Clientes.php obtenidas en la funcion
              $("#paginadorCompras").html(item.paginador);
              //console.log(item);
            } catch (error) {
              $("#paginadorCompras").html(response);
            }
          }
        );
      }
      dataProveedor(data){
this.data = data;
console.log(data);
$("#Proveedor").val(data.Proveedor);
      }
      detallesCompras(){
          var valor = true;
          if (this.data !=null) {
              var data = new FormData();
              $.each($('input[type=file]')[0].files, (i, file)=>{
data.append('file',file);
              });
              var url = "Compras/detallesCompras";
              var credito = document.getElementById("Credito").checked;
              data.append("idCliente", this.IdCliente);
      data.append("Descripcion", $('#Descripcion').val());
      data.append("Cantidad", $('#Cantidad').val());
      data.append("Precio", $('#Precio').val());
      data.append("IdProveedor", this.data.IdProveedor);
      data.append("Proveedor", $('#Proveedor').val());
      data.append("Email", this.data.Email);
      data.append("credito", credito);
      $.ajax({
        url: URL + url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: (response) => {
         try{
           let item = JSON.parse(response);
            localStorage.setItem("Compra", JSON.stringify(new Array(
              $('#Descripcion').val(),
              $('#Cantidad').val(),
              $('#Precio').val(),
              this.data.Proveedor,
              $('#Proveedor').val(),
              this.data.Email,
              credito,
              item.Codigo,
              item.results
            )));
            window.location.href = URL + "Compras/detalles";
          } catch(error) {
            document.getElementById("messageCompras").innerHTML=response;
          }
        }
      });
      valor = false;
          } else {
              valor = true;
              document.getElementById("messageCompras").innerHTML = "Seleccione un proveedor";
          }
          return valor;
      }
      detalles(){
        var item = JSON.parse(localStorage.getItem("Compra"));
        document.getElementById("dProveedor").innerHTML="Proveedor: " +item[3];
        document.getElementById("dProducto").innerHTML=item[0];
        document.getElementById("dPrecio").innerHTML="$" + numberDecimales(item[2]);
        document.getElementById("dCantidad").innerHTML=item[1];
        var importe =item[2] * item[1];
        if (item[6]) {
          document.getElementById("dCredito").innerHTML = '<span class="green-text text-darken-3">Activo</span>';
          var deuda = importe + parseFloat(item[8].Deuda.replace("$", "").replace(",",""));
          $("#deuda").html("$"+numberDecimales(deuda));//numberdecimal convierte a decimal
          $("#fechadeuda").html(getFechas());
          $("#pago").html(item[8].Pago);
          $("#fechapago").html(item[8].FechaPago);
          $("#ticket").html(item[8].Ticket);
          $("#proveedorNombre").html("Proveedor: " +item[3]);
        } else {
          document.getElementById("dCredito").innerHTML = '<span class="deep-orange-text text-darken-4">No disponible</span>';
        }
        
        document.getElementById("dImporte").innerHTML = "$" + numberDecimales(importe);
        document.getElementById("dFecha").innerHTML = getFechas();
        document.getElementById("imageDetalles").innerHTML = [
          '<img class="responsive-img" src="',
          URL + FOTOS + "Compras/" + item[7] + ".png",
          '"title="',
          escape(item[7]),
          '"/>',
        ].join("");
      }
      Comprar(){
        $.post(
          URL + "Compras/comprar",
          {},
          (response)=>{
            console.log(response);
          }
        );
      }
}