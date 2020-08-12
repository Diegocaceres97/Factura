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
              data.append("idCliente", this.IdCliente);
      data.append("Descripcion", $('#Descripcion').val());
      data.append("Cantidad", $('#Cantidad').val());
      data.append("Precio", $('#Precio').val());
      data.append("IdProveedor", this.data.IdProveedor);
      data.append("Proveedor", $('#Proveedor').val());
      data.append("Email", this.data.Email);
      data.append("creditos", document.getElementById("Credito").checked);
          } else {
              valor = true;
              document.getElementById("messageCompras").innerHTML = "Seleccione un proveedor";
          }
      }
}