class Uploadpicture{
    constructor(){
        
    }
    archivo(evt,id) {
        let files = evt.target.files;//FileList object
        let f = files[0];
        if (f.type.match('image.*')) {
            let reader = new FileReader();
            reader.onload = ((theFile) => {//con el objeto de arriba invocamos la propiedad con la funcion anonima
                return (e) => {//esta funcion recibira un parametro y retornara la funcion 
                    document.getElementById(id).innerHTML = ['<img class="responsive-img " src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
                };//obtuvimos la direccion de nuestra foto o imagen que hemos cargado del pc (escape) y con la propiedad name obtenemos el nombre de la imagen
            })(f);
            reader.readAsDataURL(f);//vamos a leer la url de nuestra imagen que cargamos desde la pc
        }
    }
}