<?php

/**
 * Constantes do Sistema
 */
define('APP_HOST'               , $_SERVER['HTTP_HOST'] . '/php-busca-paginacao');
define('PATH'                   , str_replace('\\', '/', realpath('./')));
define('NAMESPACE_CONTROLLERS'  , 'App\\Controllers\\');
define('CONTROLLER_PADRAO'      , 'HomeController');
define('METODO_PADRAO'          , 'index');

//CONSTANTES PARA CONEXAO COM O BD
define('DB_HOST'                , 'localhost');
define('DB_NAME'                , 'dbproduto');
define('DB_USER'                , 'root');
define('DB_PASS'                , '');
define('DB_DRIVER'              , 'mysql');