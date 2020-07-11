<?php

use app\model\Login;
use app\model\Route;

// if(Login::logado()){
//   Route::header(Route::pag_Home());
// }

if(!empty($_POST['registration']) && !empty($_POST['pass'])){
  $registration = $_POST['registration'];
  $pass = $_POST['pass'];

  $login = new Login();
  $login->getLogin($registration, $pass);
}

echo template('login.html', array(
  "RAIZ"=>Route::get_Raiz(),
  "SRC" => Route::get_Src(),
  "VENDOR" => Route::get_Vendor(),
  "PAG_CADASTRAR" => Route::pag_Cadastrar(),
  "PAG_ESQUECI_SENHA" => Route::pag_EsqueciSenha()
));

?>
