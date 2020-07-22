<?php
class Index extends Controllers
{
    public function __construct() {
      parent :: __construct();//Ejecutamos el constructor padre
      //echo "Controladora index";
    }
    public function index(){
      $user = $_SESSION["User"] ?? null;
      if (null != $user) {//con esto evitamos que cuando se inicia sesion y le de atras
        header("Location:".URL."Principal/principal");     //vuelva al index 
      } else {
        $this ->view-> render($this,"index",null);//Invocamos el metodo render donde lo tenemos referenciado ya 
        //en el controllers.php de library
      }       
    }
    public function userLogin(){
    
      if(isset($_POST["email"])){
        if (!empty($_POST["password"])) {
          if(6 <= strlen($_POST["password"])){//comparamos la longitud del password
            $data =  $this->model->userLogin($_POST["email"],$_POST["password"]);//enviamos los datos a verificar M/I
            //echo $data;
            if(is_array($data)){//verificamos si el dato almacenado en el objeto es un array
    echo json_encode($data);
            }else{
    echo $data;
            }
          }else{
    echo 2;
            }
          }else{
echo 1;
          }
        } 
        
      //  echo password_hash($_POST["password"], PASSWORD_DEFAULT);
       /* $data =  $this->model->userLogin($_POST["email"],$_POST["pass"]);//enviamos los datos a verificar M/I
        //echo $data;
        if(is_array($data)){//verificamos si el dato almacenado en el objeto es un array
echo json_encode($data);
        }else{
echo $data;
        }else{

        }*/
      
    }
}


?>