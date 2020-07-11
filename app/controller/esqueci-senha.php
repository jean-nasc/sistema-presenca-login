<?php

use app\model\EnviarEmail;
use app\model\Usuarios;
use app\model\Config;
use app\model\Login;
use app\model\Route;

// if(Login::logado()){
//   Route::header(Route::pag_Home());
// }

$enviar = new EnviarEmail();
$usuarios = new Usuarios();

if(!empty($_POST['email'])){

  $random = rand(10, 60); //10 À 60 CARACTERES
  $caracteres = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789";
  $token = substr(str_shuffle($caracteres), 0, $random);

  $assunto = 'Redefinição de Senha - ' . Config::SITE_NAME;
  $msg = 'Olá, recebemos uma solicitação para a redefinição de senha. <br>';
  $msg.= '<a href="'.Config::SITE_URL . Config::SITE_FOLDER.'/redefinir-senha/token/'.$token.'">CLIQUE AQUI</a> para redefinir sua senha.';
  $destinatarios = $_POST['email'];

  $usuarios->getUserEmail($destinatarios);

  if($usuarios->totalDados()>0){

    $usuarios->updateToken($token, $destinatarios);

    $enviar->enviar($assunto, $msg, $destinatarios);

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Confira seu e-mail para redefinir sua senha.</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
  }else{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>E-mail não cadastrado em nosso banco de dados!</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
  }
}

echo template('esqueci-senha.html', array(
  "RAIZ"=>Route::get_Raiz(),
  "SRC" => Route::get_Src(),
  "VENDOR" => Route::get_Vendor(),
  "PAG_LOGIN" => Route::pag_Login()
));

?>
