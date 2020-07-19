class Principal {
  constructor() {}
  linkprincipal(link) {
    if (
      link == PATHNAME + "Principal/principal" ||
      link == PATHNAME + "Principal/principal/"
    ) {
      document.getElementById("enlace1").classList.add("active");
      let user = JSON.parse(localStorage.getItem("user"));
    }

    if (
      link == PATHNAME + "Usuarios/usuarios" ||
      link == PATHNAME + "Usuarios/usuarios/"
    ) {
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
    }
    if(link == PATHNAME + "Clientes/clientes" || link==PATHNAME+"Clientes/clientes/"){
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
    }
  }
}
