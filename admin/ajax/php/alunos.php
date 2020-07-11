<?php

require_once 'connection.php';

if(!empty($_POST['date_pres']) && isset($_POST['hour_pres'])){

  $data = explode("-", $_POST['date_pres']);
  $date_pres = $data[2] . "/" . $data[1] . "/" . $data[0];

  $hora = $_POST['hour_pres'];

  if($hora > 0 && $hora != 13){
    $stmt = $conn->prepare("SELECT A.name, A.last_name, A.registration, P.date_pres, P.hour_pres FROM tb_alunos AS A JOIN tb_presenca AS P ON P.id_aluno = A.id WHERE P.date_pres = :data AND P.hour_pres >= :hora AND P.hour_pres < :hora_limite");
    $stmt->execute(array(
      ':data' => $date_pres,
      ':hora' => $hora,
      ':hora_limite' => $hora + 2
    ));

    $result = $stmt->fetchAll();
    $i=0;

    if ( count($result) > 0 ) {
      foreach($result as $row) {
        $i=$i+1;
        echo '
        <tr id="resultado">
        <th>'.$i.'</th>
        <td>'.$row['name'].'</td>
        <td>'.$row['last_name'].'</td>
        <td>'.$row['registration'].'</td>
        <td>'.$row['date_pres'].'</td>
        <td>'.$row['hour_pres'].'</td>
        </tr>

        ';
      }
    } else {

    }

  }elseif($hora == 13){

    $stmt = $conn->prepare("SELECT A.name, A.last_name, A.registration, P.date_pres, P.hour_pres FROM tb_alunos AS A JOIN tb_presenca AS P ON P.id_aluno = A.id WHERE P.date_pres = :data AND P.hour_pres >= :hora AND P.hour_pres < :hora_limite");
    $stmt->execute(array(
      ':data' => $date_pres,
      ':hora' => $hora,
      ':hora_limite' => $hora + 1
    ));

    $result = $stmt->fetchAll();
    $i=0;

    if ( count($result) > 0 ) {
      foreach($result as $row) {
        $i=$i+1;
        echo '
        <tr id="resultado">
        <th>'.$i.'</th>
        <td>'.$row['name'].'</td>
        <td>'.$row['last_name'].'</td>
        <td>'.$row['registration'].'</td>
        <td>'.$row['date_pres'].'</td>
        <td>'.$row['hour_pres'].'</td>
        </tr>

        ';
      }
    } else {

    }

  }else{

    $stmt = $conn->prepare("SELECT A.name, A.last_name, A.registration, P.date_pres, P.hour_pres FROM tb_alunos AS A JOIN tb_presenca AS P ON P.id_aluno = A.id WHERE P.date_pres = :data AND P.hour_pres >= :hora");
    $stmt->execute(array(
      ':data' => $date_pres,
      ':hora' => $hora
    ));

    $result = $stmt->fetchAll();
    $i=0;

    if ( count($result) > 0 ) {
      foreach($result as $row) {
        $i=$i+1;
        echo '
        <tr id="resultado">
        <th>'.$i.'</th>
        <td>'.$row['name'].'</td>
        <td>'.$row['last_name'].'</td>
        <td>'.$row['registration'].'</td>
        <td>'.$row['date_pres'].'</td>
        <td>'.$row['hour_pres'].'</td>
        </tr>

        ';
      }
    } else {

    }

  }

}

?>
