<?php

namespace app\model;

use PHPMailer\PHPMailer\PHPMailer;

Class EnviarEmail extends PHPMailer{

  function enviar($assunto, $msg, $destinatarios){

    $this->IsSMTP(); //Defino que é SMTP

    $this->IsHTML(true);  //Se é em HTML

    $this->CharSet = 'UTF-8'; //Codificação charset padrão UTF-8

    $this->SMTPDebug = 0; //Modo debug 0 = off 1 e 2 = mostram informações do envio ou erros

    $this->SMTPSecure = Config::EMAIL_SMTPSECURE; //Tipo de certificado SSL/TLS

    $this->Port = Config::EMAIL_PORT; //Indica a porta do seu servidor

    $this->Host = Config::EMAIL_HOST; //smtp.dominio.com.br (seu servidor SMTP)

    $this->SMTPAuth = Config::EMAIL_SMTPAUTH; //Define se tem autenticação no SMTP

    //Define dados do remetente EMAIL, SENHA da conta SMTP
    $this->FromName    = Config::EMAIL_NAME;
    $this->From        = Config::EMAIL_ADMIN;
    $this->Username    = Config::EMAIL_ADMIN;
    $this->Password    = Config::EMAIL_PASS;


    //Pego dados da mensagem
    $this->Subject  =  $assunto;
    $this->Body     =  $msg;


    //E-mail de resposta
    //$this->AddReplyTo($reply);

    //E-mail para receber uma cópia
    //$this->Addcc(Config::EMAIL_COPY);

    $this->AddAddress($destinatarios);

    $this->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ));

    //Enviando o e-mail
    if($this->Send()){
      $this->ClearAllRecipients();
    }else{
      echo "<h4> Mailer Error: " . $this->ErrorInfo . " </h4>";
    }

  }

}

?>
