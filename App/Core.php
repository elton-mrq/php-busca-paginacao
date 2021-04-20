<?php

namespace App;

use Exception;

class Core
{
    private $controller;
    private $action;
    private $params = [];

    public function __construct()
    {
        $this->url();
    }

    public function run()
    {
        
        $controllerFile   = $this->controller . '.php';
        if(!file_exists(NAMESPACE_CONTROLLERS . $controllerFile)){
            throw new Exception("Página não encontrada!", 404);
        }

        $nomeClasse            = NAMESPACE_CONTROLLERS . $this->controller;
        if(!class_exists($nomeClasse)){
            throw new Exception("Erro na aplicação!", 500);
        }

        $objController = new $nomeClasse($this);
        if(method_exists($objController, $this->action)){
           call_user_func_array([$objController, $this->action], $this->params);
            return;
        }else{
            throw new Exception("Nosso suporte já esta verificando, desculpe!", 500);
        }
        

        throw new Exception("Página não encontrada!", 404);

    }

    public function url()
    {
        $path = $_GET['url'];
        $path = rtrim($path, '/');
        $path = filter_var($path, FILTER_SANITIZE_URL);

        $path = explode('/', $path);

        $this->controller      = ($this->verificaArray($path, 0)) ? ucwords($this->verificaArray($path, 0)).'Controller' : CONTROLLER_PADRAO;
        $this->controller      = preg_replace('/[^a-zA-Z]/i', '', $this->controller);

        $this->action          = ($this->verificaArray($path, 1)) ? $this->verificaArray($path, 1) : METODO_PADRAO;
        $this->action          = preg_replace('/[^a-zA-Z]/i', '', $this->action);

        if($this->verificaArray($path, 2)){
            unset($path[0]);
            unset($path[1]);
            $this->params = array_values($path);
        }
    }

    public function verificaArray($array, $key)
    {
        if(isset($array[$key]) && !empty($array[$key])){
            return $array[$key];
        }
        return null;
    }

    
    public function getController()
    {
        return $this->controller;
    }

   
    public function getAction()
    {
        return $this->action;
    }

}