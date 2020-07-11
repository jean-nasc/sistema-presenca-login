<?php

require_once 'connection.php';

if(isset($_POST['pass']) && $_POST['pass']!=Null){

  $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT, array('cost'=>11));
  $ref = $_POST['update'];


  $stmt = $conn->prepare("UPDATE tb_alunos SET pass = :pass WHERE id = :id");

  $params = array(
    ':pass'=>$pass,
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
