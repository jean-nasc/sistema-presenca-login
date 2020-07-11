<?php

use app\model\Login;
use app\model\Route;

if(Login::logado()){
  Route::header(Route::get_AlunosADM());
}

if(!empty($_POST['email']) && !empty($_POST['pass'])){
  $emailAdmin = $_POST['email'];
  $passAdmin = $_POST['pass'];

  $login = new Login();
  $login->getLoginAdmin($emailAdmin, $passAdmin);
}

echo template('login.html', array(
  "RAIZ"=>Route::get_Raiz(),
  "SRC"=>Route::get_Src(),
  "VENDOR"=>Route::get_Vendor()
));

?>
