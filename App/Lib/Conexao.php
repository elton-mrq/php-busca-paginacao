<?php

namespace App\Lib;

use Exception;
use PDO;
use PDOException;

class Conexao
{
    private static $connection = null;

    public static function getConnection()
    {
        $pdoConfig = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME;

        try {
            
            if(self::$connection === null){
                self::$connection = new PDO($pdoConfig, DB_USER, DB_PASS);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

            return self::$connection;

        } catch (PDOException $exc) {
            
            throw new Exception('Erro de conexão com o Banco de Dados!', 401);

        }       
        
    }
}