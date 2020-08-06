class Principal {
  constructor() {}
  linkprincipal(link) {
    let url="";
    let cadena = link.split("/");
    for (let i = 0; i < cadena.length; i++) {
      if(i>=3){
        url+=cadena[i];
      }
      
    }
    switch (url) {
      case "Principalprincipal":
        document.getElementById("enlace1").classList.add("active");
      let user = JSON.parse(localStorage.getItem("user"));
        break;
        case "Usuariosusuarios":
          document.getElementById("enlace2").classList.add("active");
          document
            .getElementById("files")
            .addEventListener("change", archivo, false); //le agregaremos un evento al imputfile en html usuarios
          document.getElementById("fotos").innerHTML = [
            '<img class="responsive-img" src="',
            PATHNAME + "RESOURCE/IMAGES/fotos/usuarios/default.png",
            '"title="',
            ,
            '"/>',
          ].join("");
          getRoles();
          getUsers(1); //al invocarlo por primera vez entrará en la página 1
          break;
          case "Clientesclientes":
            document.getElementById("fotoCliente").innerHTML = [
              '<img class="responsive-img" src="',
              PATHNAME + "RESOURCE/IMAGES/fotos/clientes/default.png",
              '"title="',
              ,
              '"/>',
            ].join("");
            getCreditos();
            document
              .getElementById("files")
              .addEventListener("change", fotoCliente, false);
              getClientes(1);
          break;
          case "Clientesreportes":
          var email = getParameterByName('email');
          if (email!=null) {//todas estas son validaciones que brindan de mas seguridadd al proyecto
            if (validarEmail(email)) {
            new Clientes().getReporteCliente(email);
            }else{
              window.location.href= URL + "Clientes/clientes";
          }}else{
            window.location.href= URL + "Clientes/clientes";
          }
          break;
      case "Proveedoresregistrar":
        var email = getParameterByName('email');
        if(email!=null && email!=""){
          dataProveedor(email);
        }
        document
        .getElementById("files")
        .addEventListener("change", fotoProveedor, false);
        break;
        case "Proveedoresproveedores":
        getProveedores(1);
          break;
          case "Proveedoresreportes":
          var email = getParameterByName('email');
          if (email!=null) {//todas estas son validaciones que brindan de mas seguridadd al proyecto
            if (validarEmail(email)) {
            new Proveedores().getReportePro(email);
            }else{
              window.location.href= URL + "Proveedor/proveedor";
          }}else{
            window.location.href= URL + "Proveedor/proveedor";
          }
          break;
      }
   
  }
}
