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
              try {
                let item =JSON.parse(response);
                document.getElementById("productoCompraImg").innerHTML = [
                  '<img class="responsive-img " src="',
                  URL + FOTOS + "Compras/" + item[0].Codigo+".png",
                  '" title="',
                  escape(item[0].Codigo),
                  '"/>',
                ].join("");
               
var importe = this.humanizeNumber(item[0].Precio);
                document.getElementById("Descripcion").value = item[0].Descripcion; //dejaremos las entradas en blanco para cuando acabemos de resgistrar
                      document.getElementById("productProveedor").value = item[0].Proveedor;
                      document.getElementById("productDescrip").innerHTML = item[0].Descripcion;
                      document.getElementById("productPrecio").innerHTML = `$${importe}`;
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
                      $(".barcode").barcode(item[1],"code128");
              } catch (error) {
                $('#messageProductos').html(response);
              
              }
              
            }
            );
    }
    Registrar(){
     $.post(
       "registrarProducto",
       $('.registrarProducto').serialize(),
       (response)=>{
         if (response==0) {
          window.location.href = URL + "Productos/productos";

         } else {
          $('#messageProductos').html(response);
         }
       }
     )
    }
   humanizeNumber(n) { //funcion para separar miles
      n = n.toString()
      while (true) {
        var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3')
        if (n == n2) break
        n = n2
      }
      return n
    }
}