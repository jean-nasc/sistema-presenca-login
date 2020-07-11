<?php

use app\model\Route;

echo template('404.html', array(
  "RAIZ"=>Route::get_Raiz(),
  "SRC"=>Route::get_Src()
));

?>
