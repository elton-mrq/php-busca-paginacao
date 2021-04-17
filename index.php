<?php

use App\Core;
use App\Lib\Erro;

require_once 'vendor/autoload.php';
require_once 'Config/config.php';

session_start();

error_reporting(E_ALL & ~E_NOTICE);

try{
    
    $core = new Core();
    $core->run();
    
}catch(\Exception $exc){

    $objErro = new Erro($exc);
    $objErro->render();

}


