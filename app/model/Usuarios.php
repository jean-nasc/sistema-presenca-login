<?php

namespace app\model;

Class Usuarios extends DB{

  private $name, $last_name, $registration, $email, $pass;


  function cadastrarUser(){

    $this->getUser($this->registration, $this->email);

    if($this->totalDados()>0){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>E-mail ou matrícula já cadastrado!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';

    }else{

      $query = "INSERT INTO tb_alunos (name, last_name, registration, email, pass, date_reg, hour_reg) VALUES ";
      $query.= "(:name, :last_name, :registration, :email, :pass, :date_reg, :hour_reg)";

      $params = array(
        ':name' => $this->name,
        ':last_name' => $this->last_name,
        ':registration' => $this->registration,
        ':email' => $this->email,
        ':pass' => $this->pass,
        ':date_reg' => date("d/m/Y"),
        ':hour_reg' => date("H:i:s")
      );

      $this->executeSQL($query, $params);

      //Inserindo a presença ao efetuar o cadastro
      $this->getUserEmail($this->email);

      $lista = $this->listarDados();

      $query = "INSERT INTO tb_presenca (id_aluno, date_pres, hour_pres) VALUES (:id_aluno, :date_pres, :hour_pres)";

      $params = array(
        ':id_aluno' => $lista['id'],
        ':date_pres' => date("d/m/Y"),
        ':hour_pres' => date("H:i:s")
      );

      $this->executeSQL($query, $params);

      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Cadastro efetuado e presença marcada com sucesso!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';
    }
  }


  function redefinePass($pass, $email, $token_url){
    $this->setPass($pass);
    $this->setEmail($email);

    $query = "UPDATE tb_alunos SET pass = :pass, token = :token WHERE email = :email AND token = :token_url";
    $params = array(
      ':pass' => $this->pass,
      ':token' => NULL,
      ':email' => $this->email,
      ':token_url' => $token_url
    );

    $this->executeSQL($query, $params);
  }


  function updateToken($token, $email){
    $this->setEmail($email);

    $query = "UPDATE tb_alunos SET token = :token WHERE email = :email";
    $params = array(
      ':token' => $token,
      ':email' => $this->email
    );

    $this->executeSQL($query, $params);
  }


  function updateUser($id_user){

    $query = "UPDATE tb_alunos SET name = :name, last_name = :last_name, registration = :registration, email = :email WHERE id = :id";
    $params = array(
      ':name' => $this->name,
      ':last_name' => $this->last_name,
      ':registration' => $this->registration,
      ':email' => $this->email,
      ':id' => $id_user
    );

    $this->executeSQL($query, $params);
  }


  function updateUserPass($id_user, $pass){

    $this->setPass($pass);

    $query = "UPDATE tb_alunos SET pass = :pass WHERE id = :id";
    $params = array(
      ':pass' => $this->pass,
      ':id' => $id_user
    );

    $this->executeSQL($query, $params);
  }


  function getUser($registration, $email){
    $this->setRegistration($registration);
    $this->setEmail($email);

    $query = "SELECT * FROM tb_alunos WHERE registration = :registration OR email = :email";
    $params = array(
      ':registration' => $this->registration,
      ':email' => $this->email
    );

    $this->executeSQL($query, $params);
  }


  function getUserEmail($email){
    $this->setEmail($email);

    $query = "SELECT * FROM tb_alunos WHERE email = :email";
    $params = array(
      ':email' => $this->email
    );

    $this->executeSQL($query, $params);
  }


  function getUserAll($data, $hora){
    $query = "SELECT A.name, A.last_name, A.registration, P.date_pres, P.hour_pres FROM tb_alunos AS A JOIN tb_presenca AS P ON P.id_aluno = A.id WHERE P.date_pres = :data AND P.hour_pres >= :hora";

    $params = array(
      ':data' => $data,
      ':hora' => $hora
    );
    $this->executeSQL($query, $params);

    $this->getLista();
  }


  function getUserPresente($data, $registration){
    $query = "SELECT A.name, A.last_name, A.registration, P.date_pres, P.hour_pres FROM tb_alunos AS A JOIN tb_presenca AS P ON P.id_aluno = A.id WHERE P.date_pres = :data AND A.registration = :registration";

    $params = array(
      ':data' => $data,
      ':registration' => $registration
    );
    $this->executeSQL($query, $params);

    $this->getLista();
  }


  function getAlunosAll($search){
    $query = "SELECT * FROM tb_alunos WHERE name LIKE '%$search%' OR last_name LIKE '%$search%' OR registration LIKE '%$search%'";

    $this->executeSQL($query);

    $this->getListaAll();
  }


  function deleteUser($ref){
    $query = "DELETE FROM tb_alunos WHERE id = :id";
    $params = array(
      ':id' => $ref
    );

    $this->executeSQL($query, $params);
  }


  private function getLista(){
    $i = 1;

    while($lista = $this->listarDados()){
      $this->itens[$i] = array(
        'name' => $lista['name'],
        'last_name' => $lista['last_name'],
        'registration' => $lista['registration'],
        'date_pres' => $lista['date_pres'],
        'hour_pres' => $lista['hour_pres']
      );

      $i++;
    }
  }


  private function getListaAll(){
    $i = 1;

    while($lista = $this->listarDados()){
      $this->itens[$i] = array(
        'id' => $lista['id'],
        'name' => $lista['name'],
        'last_name' => $lista['last_name'],
        'registration' => $lista['registration'],
        'email' => $lista['email'],
        'pass' => $lista['pass']
      );

      $i++;
    }
  }


  function preparar($name, $last_name, $registration, $email, $pass){
    $this->setName($name);
    $this->setLastName($last_name);
    $this->setRegistration($registration);
    $this->setEmail($email);
    $this->setPass($pass);
  }


  private function setName($name){
    $this->name = strip_tags(trim(addslashes(mb_strtoupper($name, "UTF-8"))));
  }

  private function setLastName($last_name){
    $this->last_name = strip_tags(trim(addslashes(mb_strtoupper($last_name, "UTF-8"))));
  }

  private function setRegistration($registration){
    $this->registration = strip_tags(trim(addslashes($registration)));
  }

  private function setEmail($email){
    $this->email = strtolower(trim(filter_var($email, FILTER_SANITIZE_EMAIL)));
  }

  private function setPass($pass){
    $this->pass = password_hash($pass, PASSWORD_BCRYPT, array('cost'=>11));
  }


  function getName(){
    return $this->name;
  }

  function getLastName(){
    return $this->last_name;
  }

  function getRegistration(){
    return $this->registration;
  }

  function getEmail(){
    return $this->email;
  }

  function getPass(){
    return $this->pass;
  }

}

?>
