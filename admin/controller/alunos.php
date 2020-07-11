<?php

use app\model\Route;
use app\model\Login;
use app\model\Usuarios;

$usuarios = new Usuarios();

if(!Login::logado()){
  Route::header(Route::get_LoginADM());
}

if(isset($_POST['date_pres']) && $_POST['date_pres'] != Null && isset($_POST['hour_pres']) && $_POST['hour_pres'] != Null){

  $data = explode("-", $_POST['date_pres']);
  $date_pres = $data[2] . "/" . $data[1] . "/" . $data[0];

  $hour_pres = $_POST['hour_pres'];

  $usuarios->getUserAll($date_pres, $hour_pres);

}

echo template('alunos.html', array(
  "RAIZ"=>Route::get_Raiz(),
  "SRC"=>Route::get_Src(),
  "VENDOR"=>Route::get_Vendor(),
  "PAG_LOGOFF"=>Route::get_LogoffADM(),
  "PAG_EDITAR"=>Route::get_UsuariosADM(),
  "USER_NAME" => (isset($_SESSION['USER']) ? $_SESSION['USER']['name'] : NULL),
  "USERS_ALL"=>$usuarios->getItens()
));

?>
