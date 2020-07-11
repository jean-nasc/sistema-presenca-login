<?php

use app\model\Route;
use app\model\Login;
use app\model\Usuarios;

$usuarios = new Usuarios();

if(!Login::logado()){
  Route::header(Route::get_LoginADM());
}

// if(isset($_POST['delete'])){
//   $ref = $_POST['delete'];
//   $usuarios->deleteUser($ref);
// }

//Alterar informações dos alunos
if(isset($_POST['name']) && isset($_POST['last_name']) && isset($_POST['registration']) && isset($_POST['email'])){

  $name = $_POST['name'];
  $last_name = $_POST['last_name'];
  $registration = $_POST['registration'];
  $email = $_POST['email'];

  $usuarios->preparar($name, $last_name, $registration, $email, $pass=Null);

  $ref = $_POST['update'];
  $usuarios->updateUser($ref);
}

//Alterar somente a senha
if(isset($_POST['pass']) && $_POST['pass']!=Null){
  $pass = $_POST['pass'];

  $ref = $_POST['update'];
  $usuarios->updateUserPass($ref, $pass);
}

//Barra de pesquisa
if(isset($_POST['search'])){
  $search = $_POST['search'];

  $usuarios->getAlunosAll($search);
}

echo template('usuarios.html', array(
  "RAIZ"=>Route::get_Raiz(),
  "SRC"=>Route::get_Src(),
  "VENDOR"=>Route::get_Vendor(),
  "PAG_LOGOFF"=>Route::get_LogoffADM(),
  "PAG_ALUNOS"=>Route::get_AlunosADM(),
  "USER_NAME" => (isset($_SESSION['USER']) ? $_SESSION['USER']['name'] : NULL),
  "USERS_ALL"=>$usuarios->getItens()
));

?>
