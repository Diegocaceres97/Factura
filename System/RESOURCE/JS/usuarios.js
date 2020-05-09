class usuarios extends Uploadpicture {
    constructor() {
        super();//con esto invocamos todas las propiedas, objetos y metodos de la clase heredada
        this.Funcion = 0; //Creamos propiedades
        this.IdUsuario = 0;
        this.Imagen = null;
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
                    document.getElementById("fotoUser1").innerHTML = ['<img class="circle responsive-img valign profile-image" src="', FOTOS +"usuarios/"+user.Imagen, '" title="', escape(user.Imagen), '"/>'].join('');
                }
            }
        }
    }
    getRoles(role, funcion) {//utilizamos este metodo para hacer una peticion al servidor para comunicarse con el controlador
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
                            switch (funcion) {
                                case 1://nuevo registro
                                    document.getElementById('roles').options[count] = new Option(item.results[i].Role, item.results[i].IdRole);
                                    count++;
                                    $('select').formSelect();//inicializamos el form select
                                    break;

                                case 2://caso para cuando se vaya a editar
                                    if (item.results[i].Role == role) {
                                        document.getElementById('roles').options[count] = new Option(item.results[i].Role, item.results[i].IdRole);
                                        i++;//i sera la posicion donde se encuentre el rol
                                        document.getElementById('roles').selectedIndex = i
                                        i--;
                                    }
                                    count++;
                                    $('select').formSelect();//inicializamos el form select
                                    break;
                            }
                        }

                    }
                } catch (error) {

                }

            }
        );

    }
    
    registerUser(nombre, apellido, nid, telefono, email, password, user, role) {

        if (validarEmail(email)) {
            if (6 <= password.length) {
                var data = new FormData();//creamos una coleccion de objetos para enviarlos al servidor
                $.each($('input[type=file')[0].files, (i, file) => {
                    data.append('file', file)
                });//aqui obtenemos la informacion de nuestro input tipo file
                //el .append crea es una coleccion de datos
                var url = this.Funcion == 0 ? "Usuarios/registerUser" : "Usuarios/editUser";//terniaria (comparacion)
                data.append('idUsuario', this.IdUsuario);
                data.append('nombre', nombre);
                data.append('apellido', apellido);
                data.append('nid', nid);
                data.append('telefono', telefono);
                data.append('email', email);
                data.append('password', password);
                data.append('usuario', user);
                data.append('role', role);
                data.append('imagen', this.Imagen);
                $.ajax({
                    url: URL + url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: (response) => {//esta propiedad contendra la funcion que va obtener la info que devuelva el servidor
                        if (response == 0) {
                            restablecerUser();
                           // location.reload();//recargamos la pagína para que se vea el registro al instante
                            alert ("REGISTRO EXITOSO");
                        } else {
                            document.getElementById("registerMessage").innerHTML = response;//se envia la respuesta al label html
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
                $("#resultUser").html(response);//el dato que capturemos del servidor lo mandaremos a resultuser
                //el resultUser es el BODY de la tabla
            }
        );
    }
    editUser(data) {//metodo donde obtendremos los datos seleccionados
        this.Funcion = 1;//con esto capturaremos la informacion necesaria para registrar usuario
        this.IdUsuario = data.IdUsuario;
        this.Imagen = data.Imagen;
        document.getElementById("fotos").innerHTML = ['<img class="responsive-img " src="', PATHNAME + "RESOURCE/IMAGES/fotos/usuarios/" + data.Imagen, '" title="', escape(data.Imagen), '"/>'].join('');
        document.getElementById("nombre").value = data.Nombre;//dejaremos las entradas en blanco para cuando acabemos de resgistrar
        document.getElementById("apellido").value = data.Apellido;
        document.getElementById("nid").value = data.NID;
        document.getElementById("telefono").value = data.Telefono;
        document.getElementById("email").value = data.Email;
        document.getElementById("usuario").value = data.Usuario;
        document.getElementById("password").value = "*********";
        document.getElementById("password").disabled = true;

        this.getRoles(data.Roles, 2);
    }
    deleteUser(data){
        $.post(//enviamos los datos por post
            URL + "Usuarios/deleteUser",
            {
                idUsuario:data.IdUsuario,
                email:data.Email
            },
            (response) => {
                if(response==0){
                    this.restablecerUser();
                }else{
                    document.getElementById("deteUserMessage").innerHTML=response;
                }
                console.log(response);
            }
        );  
    }
    restablecerUser() {
        this.Funcion = 0; //Creamos propiedades
        this.IdUsuario = 0;
        this.Imagen = null;
        document.getElementById("fotos").innerHTML = ['<img class="responsive-img" src="', URL + "RESOURCE/IMAGES/fotos/usuarios/default.png", '"title="', , '"/>'].join('');
        this.getRoles(null, 1);
        var instance = M.Modal.getInstance($('#modal1'));//instanciacion del modal para cerrarlo en este objeto
        var instance = M.Modal.getInstance($('#modal2'));
        instance.close();
        document.getElementById("nombre").value = "";//dejaremos las entradas en blanco para cuando acabemos de resgistrar
        document.getElementById("apellido").value = "";
        document.getElementById("nid").value = "";
        document.getElementById("telefono").value = "";
        document.getElementById("email").value = "";
        document.getElementById("password").value = "";
        document.getElementById("usuario").value = "";
        this.getUsers(null);
    }
    sessionClose() {
        document.getElementById('menuNavbar1').style.display = 'none';
        document.getElementById('menuNavbar2').style.display = 'none';
    }
}