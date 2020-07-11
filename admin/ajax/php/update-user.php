<?php

require_once 'connection.php';

if(!empty($_POST['name']) && !empty($_POST['last_name']) && !empty($_POST['registration']) && !empty($_POST['email']) && !empty($_POST['update'])){

  $name = strip_tags(trim(addslashes(mb_strtoupper($_POST['name'], "UTF-8"))));
  $last_name = strip_tags(trim(addslashes(mb_strtoupper($_POST['last_name'], "UTF-8"))));
  $registration = strip_tags(trim(addslashes($_POST['registration'])));
  $email = strtolower(trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)));

  $ref = $_POST['update'];

  $stmt = $conn->prepare("UPDATE tb_alunos SET name = :name, last_name = :last_name, registration = :registration, email = :email WHERE id = :id");

  $params = array(
    ':name'=>$name,
    ':last_name'=>$last_name,
    ':registration'=>$registration,
    ':email'=>$email,
    ':id'=>$ref
  );

  $stmt->execute($params);


  if ($stmt) {

    echo "Sucesso!";

  } else {
    echo "Nennhum resultado retornado.";
  }

}

?>
