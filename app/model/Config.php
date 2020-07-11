<?php

namespace app\model;

//Fuso Horário
date_default_timezone_set('America/Sao_Paulo');

Class Config{

	//LOCALHOST: INFORMAÇÕES DO SITE (CUIDADO COM A "VÍRGULA")
	const SITE_URL = "http://localhost",
	SITE_FOLDER = "/presenca",
	SITE_NAME = "Sistema de Presença",
	SITE_EMAIL_ADM = "",
	BD_LIMIT_POR_PAG = 0;

	const DB_HOST = "localhost",
	DB_NAME = "lista_presenca",
	DB_USER = "root",
	DB_PASS = "";

	//SERVIDOR: ONLINE
	// const SITE_URL = "http://localhost",
	// SITE_FOLDER = "/sistema",
	// SITE_NAME = "Sistema em Desenvolvimento",
	// SITE_EMAIL_ADM = "",
	// BD_LIMIT_POR_PAG = 0;

	// const DB_HOST = "",
	// DB_NAME = "",
	// DB_USER = "",
	// DB_PASS = "";

	//INFORMAÇÕES PARA PHP MAILER
	const EMAIL_HOST = "host do e-mail",
	EMAIL_ADMIN = "seu e-mail",
	EMAIL_NAME = "Sistema de Presença",
	EMAIL_PASS = "sua senha",
	EMAIL_PORT = 587, //se for hotmail, outlook, esta porta funciona
	EMAIL_SMTPAUTH = true,
	EMAIL_SMTPSECURE = "tls",
	EMAIL_COPY = "";

}

?>
