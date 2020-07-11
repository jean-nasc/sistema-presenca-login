<?php

namespace app\model;

use app\model\Usuarios;

session_start();

Class Login extends DB{

  private $registration, $pass, $emailAdmin, $passAdmin, $matricula, $login;

  function getLogin($registration, $pass){

    $this->setRegistration($registration);
    $this->setPass($pass);

    $query = "SELECT * FROM tb_alunos WHERE registration = :registration";
    $params = array(
      ':registration' => $this->registration
    );

    $this->executeSQL($query, $params);

    $lista = $this->listarDados();
    $digitado = $this->pass;
    $banco = $lista['pass'];


    if(password_verify($digitado, $banco)){

      //VERIFICAR SE A HORA ATUAL É MAIOR OU IGUAL A HORA DO BANCO + 2 HORAS
      $usuarios = new Usuarios();

      $data = date("d/m/Y");

      $usuarios->getUserPresente($data, $this->registration);

      if($usuarios->totalDados()>0){

        foreach($usuarios->getItens() as $lista_dados){
          $hora_banco = strtotime($lista_dados['hour_pres']);
          $hora_atual = strtotime(date("H:i:s"));
        }

        if($hora_atual >= $hora_banco + 7200){

          $query = "INSERT INTO tb_presenca (id_aluno, date_pres, hour_pres) VALUES (:id_aluno, :date_pres, :hour_pres)";

          $params = array(
            ':id_aluno' => $lista['id'],
            ':date_pres' => date("d/m/Y"),
            ':hour_pres' => date("H:i:s")
          );

          $this->executeSQL($query, $params);

          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Presença confirmada com sucesso!</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          </div>';

        }else{
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Sua presença já foi marcada!</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          </div>';
        }

      }elseif(date('i')>=50){

        $hora = date('H') + 1 . ":00";

        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Por favor, tente novamente às '.$hora.' horas!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';

      }else{
        $query = "INSERT INTO tb_presenca (id_aluno, date_pres, hour_pres) VALUES (:id_aluno, :date_pres, :hour_pres)";

        $params = array(
          ':id_aluno' => $lista['id'],
          ':date_pres' => date("d/m/Y"),
          ':hour_pres' => date("H:i:s")
        );

        $this->executeSQL($query, $params);

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Presença confirmada com sucesso!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
      }

    }elseif(empty($this->registration) || empty($this->pass)){

    }else{
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Senha incorreta ou o usuário não está cadastrado.</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';
    }
  }


  function getLoginAdmin($emailAdmin, $passAdmin){

    $this->setEmailAdmin($emailAdmin);
    $this->setPassAdmin($passAdmin);

    $query = "SELECT * FROM tb_admin WHERE email = :email";
    $params = array(
      ':email' => $this->emailAdmin
    );

    $this->executeSQL($query, $params);

    $lista = $this->listarDados();
    $digitado = $this->passAdmin;
    $banco = $lista['pass'];

    if(password_verify($digitado, $banco)){

      $_SESSION['USER']['id'] = $lista['id'];
      $_SESSION['USER']['name'] = $lista['name'];
      $_SESSION['USER']['last_name'] = $lista['last_name'];
      $_SESSION['USER']['email'] = $lista['email'];
      $_SESSION['USER']['pass'] = $lista['pass'];

      Route::header(Route::get_AlunosADM());

    }elseif(empty($this->emailAdmin) || empty($this->passAdmin)){

    }else{
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Senha incorreta ou o usuário não está cadastrado.</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';
    }
  }


  static function logado(){
    if(isset($_SESSION['USER']['id']) && isset($_SESSION['USER']['email'])){
      return TRUE;
    }else{
      return FALSE;
    }
  }

  static function logoff(){
    unset($_SESSION['USER']);
    Route::header(Route::get_LoginADM());
  }


  private function setEmailAdmin($emailAdmin){
    $this->emailAdmin = $emailAdmin;
  }

  private function setPassAdmin($passAdmin){
    $this->passAdmin = $passAdmin;
  }

  private function setRegistration($registration){
    $this->registration = $registration;
  }

  private function setPass($pass){
    $this->pass = $pass;
  }

  function getEmailAdmin(){
    return $this->emailAdmin;
  }

  function getPassAdmin(){
    return $this->passAdmin;
  }

  function getRegistration(){
    return $this->registration;
  }

  function getPass(){
    return $this->pass;
  }

}

?>
