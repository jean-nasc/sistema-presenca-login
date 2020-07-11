<?php

$host = 'localhost';
$dbname = 'lista_presenca';
$username = 'root';
$password = '';

try{

  $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
  );

  $conn = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password, $options);

}catch(PDOException $e) {
  echo 'ERROR: ' . $e->getMessage();
}

?>
