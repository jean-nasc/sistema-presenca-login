<?php

use app\model\Route;
use app\model\Usuarios;
use app\model\Login;

// if(Login::logado()){
//   Route::header(Route::pag_Home());
// }

if(isset($_GET['pag'])){

  $pagina = $_GET['pag'];

  $pag = explode('/', $pagina);

  $token = $pag;

  if(empty($token[1]) || empty($token[2])){

    Route::header(Route::pag_Login());

  }elseif(!empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['confirm_pass'])){

    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $confirm_pass = $_POST['confirm_pass'];
    $token_url = $token[2];

    if($pass != $confirm_pass){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>As senhas não correspondem!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';
    }else{
      $usuarios = new Usuarios();
      $usuarios->redefinePass($pass, $email, $token_url);

      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Senha redefinida com sucesso!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';

      Route::redirecionar(2, Route::pag_Login());
    }

  }

}

echo template('redefinir-senha.html', array(
  "RAIZ"=>Route::get_Raiz(),
  "SRC" => Route::get_Src(),
  "VENDOR" => Route::get_Vendor(),
  "PAG_LOGIN" => Route::pag_Login()
));

?>
