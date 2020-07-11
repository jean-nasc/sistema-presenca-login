<?php

use app\model\Login;
use app\model\Route;

if(!Login::logado()){
  Route::header(Route::get_LoginADM());
}

Login::logoff();

?>
