class usuarios {
    constructor() {

    }
    loginUser(email, pass) {
        //console.log (pass); //PRUEBA
        if (email == "") {
            document.getElementById("email").focus();
            M.toast({ html: 'ingrese el email', classes: 'rounded' }); //Esto esta dotado por el materialize
        } else {
            if (pass == "") {
                document.getElementById("password").focus();
                M.toast({ html: 'ingrese el password', classes: 'rounded' }); //Esto esta dotado por el materialize
            } else {
                if (validarEmail(email)) {
                    if (6 <= pass.length) {
                        $.post(//enviamos los datos por POST
                            "Index/userLogin",//Buscamos el metodo en index y después el metodo
                            { email, pass },
                            (response) => {//capturamos la info que devuelva el servidor
                                console.log(response);//vamos a capturar el mensaje por vista
                                try {
                                    var item = JSON.parse(response); //lo convertimos en una colecciond de objetos ademas esto es una excepcion
                                    if (0 < item.IdUsuario) {//evaluamos el dato y si id es mayor a 0 significa que hemos iniciado sesion bien
                                        localStorage.setItem("user", response);//almacenamos elemento local en nuestra memoria local del navegador la llave es user y gaurdara los parametros del response
                                        //los datos que devolvera el servidor son de tipo string       
                                        window.location.href = URL + "Principal/principal";
                                    } else {
                                        document.getElementById("indexMessage").innerHTML = "Email o Contraseña incorrectos";
                                    }
                                } catch (error) {
                                    document.getElementById("indexMessage").innerHTML = response;
                                }
                            }
                        );
                    } else {
                        document.getElementById("password").focus();
                        M.toast({ html: 'introduzca al menos 6 caracteres', classes: 'rounded' });
                    }
                } else {
                    document.getElementById("email").focus();
                    M.toast({ html: 'ingrese un email valido', classes: 'rounded' }); //Esto esta dotado por el materialize
                }
            }
        }
    }
    userData(URLactual) {
        if (PATHNAME == URLactual) {
            localStorage.removeItem("user");//lo eliminara de la memoria local del navegador pq se encuentra en el login
            document.getElementById('menuNavbar1').style.display = 'none';
            document.getElementById('menuNavbar2').style.display = 'none';
        } else {
            if (null != localStorage.getItem("user")) {//vereificamos si tenemos datos almacenados en nuestro nav
                let user = JSON.parse(localStorage.getItem("user"));//lo convertimos en un json
                if (0 < user.IdUsuario) {
                    document.getElementById('menuNavbar1').style.display = 'block';
                    document.getElementById('menuNavbar2').style.display = 'block';
                    document.getElementById('name1').innerHTML = user.Nombre + " " + user.Apellido;
                    document.getElementById('role1').innerHTML = user.Roles;//visualizaremos por medio
                    //de la cabezera el nombre y rol del usuario
                    document.getElementById('name2').innerHTML = user.Nombre + " " + user.Apellido;//se visualiza en el panel esto
                    document.getElementById('role2').innerHTML = user.Roles;
                    document.getElementById("fotoUser").innerHTML = ['<img class="circle responsive-img valign profile-image" src="', FOTOS + user.Imagen, '" title="', escape(user.Imagen), '"/>'].join('');
                    document.getElementById("fotoUser1").innerHTML = ['<img class="circle responsive-img valign profile-image" src="', FOTOS + user.Imagen, '" title="', escape(user.Imagen), '"/>'].join('');
                }
            }
        }
    }
    getRoles() {//utilizamos este metodo para hacer una peticion al servidor para comunicarse con el controlador
        //y este retorna la coleccion de datos del tipo model
        let count = 1;
        $.post(
            URL + "Usuarios/getRoles", {}, (response) => {
                try {
                    let item = JSON.parse(response);
                    //console.log(item.results[0].Role);
                    document.getElementById('roles').options[0] = new Option("seleccione un ROL", 0);//obtenemos el control para asignar datos
                    //Option es una clase que recibe los dos parametros con lo que recive y el value
                    if (0 < item.results.length) {
                        for (let i = 0; i < item.results.length; i++) {
                            document.getElementById('roles').options[count] = new Option(item.results[i].Role, item.results[i].IdRole);
                            count++;
                            $('select').formSelect();//inicializamos el form select
                        }

                    }
                } catch (error) {

                }

            }
        );

    }
    archivo(evt) {
        let files = evt.target.files;//FileList object
        let f = files[0];
        if (f.type.match('image.*')) {
            let reader = new FileReader();
            reader.onload = ((theFile) => {//con el objeto de arriba invocamos la propiedad con la funcion anonima
                return (e) => {//esta funcion recibira un parametro y retornara la funcion 
                    document.getElementById("fotos").innerHTML = ['<img class="responsive-img " src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
                };//obtuvimos la direccion de nuestra foto o imagen que hemos cargado del pc (escape) y con la propiedad name obtenemos el nombre de la imagen
            })(f);
            reader.readAsDataURL(f);//vamos a leer la url de nuestra imagen que cargamos desde la pc
        }
    }
    registerUser(nombre, apellido, nid, telefono, email, password, user, role) {

        if (validarEmail(email)) {
            if (6 <= password.length) {
                var data = new FormData();//creamos una coleccion de objetos para enviarlos al servidor
                $.each($('input[type=file')[0].files, (i, file) => {
                    data.append('file', file)
                });//aqui obtenemos la informacion de nuestro input tipo file
                //el .append crea es una coleccion de datos
                data.append('nombre', nombre);
                data.append('apellido', apellido);
                data.append('nid', nid);
                data.append('telefono', telefono);
                data.append('email', email);
                data.append('password', password);
                data.append('usuario', user);
                data.append('role', role);
                $.ajax({
                    url: URL + "Usuarios/registerUser",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: (response) => {//esta propiedad contendra la funcion que va obtener la info que devuelva el servidor
                        if (response == 0) {
                            restablecerUser();
                        } else {
                            document.getElementById("registerMessage").innerHTML = response;
                        }

                    }
                });
            } else {
                document.getElementById("password").focus();
                document.getElementById("registerMessage").innerHTML = "Introduzca al menos 6 caracteres";
            }
        } else {
            document.getElementById("email").focus();
            document.getElementById("registerMessage").innerHTML = "ingrese una direccion de correo valida";
        }

    }
    getUsers(valor) {
        var valor = valor != null ? valor : ""; //operador terniario donde deveulve true o false dependiendo el parametro valor que devuelve 
        $.post(
            URL + "Usuarios/getUsers",
            {
                filter: valor
            },
            (response) => {
                //  $("#resultUser").html(response);
                console.log(response);
            }
        );
    }
    restablecerUser() {
        document.getElementById("fotos").innerHTML = ['<img class="responsive-img" src="', URL + "RESOURCE/IMAGES/fotos/default.png", '"title="', , '"/>'].join('');
        this.getRoles();
        var instance = M.Modal.getInstance($('#modal1'));//instanciacion del modal para cerrarlo en este obketo
        instance.close();
        document.getElementById("nombre").value = "";//dejaremos las entradas en blanco para cuando acabemos de resgistrar
        document.getElementById("apellido").value = "";
        document.getElementById("nid").value = "";
        document.getElementById("telefono").value = "";
        document.getElementById("email").value = "";
        document.getElementById("password").value = "";
        document.getElementById("usuario").value = "";
    }
    sessionClose() {
        document.getElementById('menuNavbar1').style.display = 'none';
        document.getElementById('menuNavbar2').style.display = 'none';
    }
}