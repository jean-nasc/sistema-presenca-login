<?php

require_once 'connection.php';

if(!empty($_POST['search'])){

  $search = $_POST['search'];

  $stmt = $conn->prepare("SELECT * FROM tb_alunos WHERE name LIKE '%$search%' OR last_name LIKE '%$search%' OR registration LIKE '%$search%'");
  $stmt->execute();

  $result = $stmt->fetchAll();


  if ( count($result) > 0 ) {

    echo json_encode($result);

  } else {
    echo "Nennhum resultado retornado.";
  }

}

?>
