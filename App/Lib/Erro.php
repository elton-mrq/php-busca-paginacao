<?php

namespace App\Lib;

use Exception;

class Erro
{
    private $message;
    private $code;

    public function __construct(Exception $objException)
    {
        $this->code     = $objException->getCode();
        $this->message  = $objException->getMessage();
    }

    public function render()
    {
        $varMsg = $this->message;

        if(file_exists(PATH . '/App/Views/error/' . $this->code . '.php')){
            require_once PATH . '/App/Views/layout/header.php';
            require_once PATH . '/App/Views/layout/menu.php';
            require_once PATH . '/App/Views/error/' . $this->code . '.php';
            require_once PATH . '/App/Views/layout/footer.php';
        }else{
            require_once PATH . '/App/Views/layout/header.php';
            require_once PATH . '/App/Views/layout/menu.php';
            require_once PATH . '/App/Views/error/500.php';
            require_once PATH . '/App/Views/layout/footer.php';
        }
    }
}