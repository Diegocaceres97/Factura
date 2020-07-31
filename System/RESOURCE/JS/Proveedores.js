class Proveedores extends Uploadpicture{
    constructor(){
        super();
        this.Funcion = 0;
        this.IdProve = 0;
        this.Imagen = null;
    }
    registerProve(){
        var data = new FormData(); //creamos una coleccion de objetos para enviarlos al servidor
        $.each($("input[type=file")[0].files, (i, file) => {
          data.append("file", file);
        });
        var url =
        this.Funcion == 0 ? "Proveedores/registerProve" : "";
        data.append("idProveedor", this.IdProve);
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
            console.log(response);
            },
          });
          return false;
    }
}