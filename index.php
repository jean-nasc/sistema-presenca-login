<?php

use app\model\Route;
use app\model\Usuarios;

require_once 'vendor/autoload.php';

Route::get_Pages();

//CHAMAR A VIEW
function template($pagina, $array=[]){
	$loader = new Twig_Loader_Filesystem('app/view');
	$twig = new Twig_Environment($loader);
	return $twig->render($pagina, $array);
}

?>
