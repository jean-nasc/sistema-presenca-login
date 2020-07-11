<?php

namespace app\model;

Class Route{

	public static $pag;

	static function get_Raiz(){       /*   http://localhost/site/   */
		return Config::SITE_URL . Config::SITE_FOLDER;
	}

	static function get_Root(){      /*  http://localhost/site/  Obs: Este pega desde a raiz para evitar erros que pode mudar de servidor para servidor  */
		return $_SERVER['DOCUMENT_ROOT'] . '/' . Config::SITE_FOLDER;
	}

	static function get_Src(){
		return self::get_Raiz(). '/src';
	}

	static function get_Vendor(){
		return self::get_Raiz() . '/vendor';
	}

	static function get_Media(){
		return self::get_Raiz(). '/media';
	}

	static function get_MediaImages(){
		return self::get_Media() . '/images';
	}

	static function get_MediaVideos(){
		return self::get_Media() . '/videos';
	}


	//MÉTODO PARA REDIRECIONAR
	static function redirecionar($tempo, $pagina){
		$url = '<meta http-equiv="refresh" content="'.$tempo.'; url='. $pagina .'">';
		echo $url;
	}

	//MÉTODO HEADER
	static function header($pagina){
		return header("Location: " . $pagina);
	}

	/* LINKS DAS PÁGINAS FRONT-END ---------------------------------------------*/
	static function pag_Cadastrar(){
		return self::get_Raiz(). '/cadastrar';
	}

	static function pag_Login(){
		return self::get_Raiz(). '/login';
	}

	static function pag_EsqueciSenha(){
		return self::get_Raiz(). '/esqueci-senha';
	}


	/* LINKS DAS PÁGINAS ADMINISTRATIVAS ------------------------------------------*/
	static function get_Admin(){
		return self::get_Raiz() .'/admin';
	}

	static function get_LoginADM(){
		return self::get_Admin() .'/login';
	}

	static function get_AlunosADM(){
		return self::get_Admin() .'/alunos';
	}

	static function get_UsuariosADM(){
		return self::get_Admin() .'/usuarios';
	}

	static function get_LogoffADM(){
		return self::get_Admin() .'/logoff';
	}


	/* URL AMIGÁVEL FRONT-END ----------------------------------------------------------- */
	static function get_Pages(){
		if(isset($_GET['pag'])){

			$pagina = $_GET['pag'];

			self::$pag = explode('/', $pagina);

			$pagina = 'app/controller/' .self::$pag[0] . '.php';

			if(file_exists($pagina)){
				include $pagina;
			}else{
				include 'app/controller/404.php';
			}

		}else{
			include 'app/controller/login.php';
		}
	}


	/* URL AMIGÁVEL ADMIN ----------------------------------------------------------- */
	static function get_PagesAdm(){
		if(isset($_GET['pag'])){

			$pagina = $_GET['pag'];

			self::$pag = explode('/', $pagina);

			$pagina = 'controller/' .self::$pag[0] . '.php';

			if(file_exists($pagina)){
				include $pagina;
			}else{
				include 'controller/404.php';
			}

		}else{
			include 'controller/login.php';
		}
	}

}

?>
