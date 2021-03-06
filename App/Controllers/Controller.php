<?php

namespace App\Controllers;

use App\Lib\Sessao;
use App\lib\ConversorMonetario;

abstract class Controller
{
    protected $core;
    private $viewVar;

    public function __construct($core)
    {
        $this->setViewParam('nameController', $core->getController());
        $this->setViewParam('nameAction', $core->getAction());
    }

    public function render($view)
    {
        $viewVar = $this->getViewVar();
        $Sessao = Sessao::class;
        $ConversorMonetario = ConversorMonetario::class;

        require_once PATH . '/App/Views/layout/header.php';
        require_once PATH . '/App/Views/layout/menu.php';
        require_once PATH . '/App/Views/' . $view . '.php';
        require_once PATH . '/App/Views/layout/footer.php';
    }

    public function redirect($view)
    {
        header('Location: http://' . APP_HOST . $view);
        exit;
    }

    public function getViewVar()
    {
        return $this->viewVar;
    }
    
    public function setViewParam($varName, $varValue)
    {
        if ($varName != "" && $varValue != "") {
            $this->viewVar[$varName] = $varValue;
        }
    }
}