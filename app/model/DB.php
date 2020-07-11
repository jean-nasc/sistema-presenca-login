<?php

namespace app\model;
use PDO;

Class DB extends Config{

	private $host, $user, $pass, $database;

	protected $obj, $itens=array();

	function __construct(){
		$this->host = self::DB_HOST;
		$this->database = self::DB_NAME;
		$this->user = self::DB_USER;
		$this->pass = self::DB_PASS;

		try{
			if($this->connect() == NULL){
				$this->connect();
			}
		}catch (Exception $e){
			exit($e->getMessage().'<h2> Erro ao tentar conexão com o banco de dados! </h2>');
		}

	}

	private function connect(){
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
			PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
		);
		$pdo = new PDO("mysql:host={$this->host};dbname={$this->database}",
		$this->user, $this->pass, $options);
		return $pdo;
	}

	function executeSQL($query, $params = NULL){
		$this->obj = $this->connect()->prepare($query);

		if(isset($params)){
			if(count($params) > 0){
				foreach($params as $key => $value){ //Para cada item do array, uma chave e um valor.
					$this->obj->bindValue($key, $value);
				}
			}
		}

		return $this->obj->execute();
	}

	function listarDados(){
		return $this->obj->fetch(PDO::FETCH_ASSOC);
	}

	function totalDados(){
		return $this->obj->rowCount();
	}

	function getItens(){  //No model passa por um foreach com a variável itens, para ser pego aqui com o encadeamento.
		return $this->itens;
	}

}

?>
