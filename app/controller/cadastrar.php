<?php

use app\model\Route;
use app\model\Usuarios;

$usuarios = new Usuarios();

if(!empty($_POST['name']) && !empty($_POST['last_name']) && !empty($_POST['registration']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['confirm_pass'])){

  $name = $_POST['name'];
  $last_name = $_POST['last_name'];
  $registration = $_POST['registration'];
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $confirm_pass = $_POST['confirm_pass'];

  if($pass != $confirm_pass){

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>As senhas não correspondem!</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';

  }else{

    $usuarios->preparar($name, $last_name, $registration, $email, $pass);
    $usuarios->cadastrarUser();

  }

}

echo template('cadastrar.html', array(
  "RAIZ"=>Route::get_Raiz(),
  "SRC" => Route::get_Src(),
  "VENDOR" => Route::get_Vendor(),
  "PAG_LOGIN" => Route::pag_Login()
));

?>
