class Productos{
    constructor(){

    }
    getCompras(page){
        $.post(
            URL + "productos/getCompras",
            { search: $("#searchComprasPD").val(), page: page },
            (response) => {
              //console.log(response);
             try {
                let item = JSON.parse(response);
                $(".productoCompras").html(item.dataFilter); //nombre de las propiedades item de Clientes.php obtenidas en la funcion
                $("#productoComprasPD").html(item.paginador);
                //console.log(item);
              } catch (error) {
                $("#productoComprasPD").html(response);
              }
            }
          );
    }
    dataProducto(IdTemp){
        $.post(
            URL + "Productos/getProducto",
            { IdTemp: IdTemp },
            (response) => {
         /*     switch(response){
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
              }*/
              try {
                let item =JSON.parse(response);
                document.getElementById("productoCompraImg").innerHTML = [
                  '<img class="responsive-img " src="',
                  URL + FOTOS + "Compras/" + item[0].Codigo+".png",
                  '" title="',
                  escape(item[0].Codigo),
                  '"/>',
                ].join("");
                document.getElementById("Descripcion").value = item[0].Descripcion; //dejaremos las entradas en blanco para cuando acabemos de resgistrar
                      document.getElementById("productProveedor").value = item[0].Proveedor;
                      document.getElementById("productDescrip").innerHTML = item[0].Descripcion;
                      document.getElementById("productPrecio").innerHTML = item[0].Precio;
                      document.getElementById("productCantidad").innerHTML = item[0].Cantidad;
                      if(item[0].Credito){
                        document.getElementById("productCredito").innerHTML 
                        = "<span class='green-text text-darken-3'>Activo</span>";
                      }else{
                        document.getElementById("productCredito").innerHTML 
                        = "<span class='deep-orange-text text-darken-4'>No disponible</span>";
                      }
                      document.getElementById("productImporte").innerHTML = item[0].Importe;
                      document.getElementById("productFecha").innerHTML = item[0].Fecha;
              } catch (error) {
              
              }
              
            }
            );
    }
}