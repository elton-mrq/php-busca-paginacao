<?php

namespace App\Controllers;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Models\DAO\ProdutoDAO;

class ProdutoController extends Controller
{
    public function index(){
       
        $produtoDAO = new ProdutoDAO();

        $paginaSelecionada      = isset($_GET['paginaSelecionada']) ? $_GET['paginaSelecionada'] : 1;
        $totalPorPagina         = 10;
   
        if(isset($_GET['buscaProduto'])){
            $listaProduto       = $produtoDAO->buscaComPaginacao($_GET['buscaProduto'], $totalPorPagina, $paginaSelecionada);

            $paginacao = new Paginacao($listaProduto);

            $this->setViewParam('buscaProduto', $_GET['buscaProduto']);
            $this->setViewParam('paginacao', $paginacao->criandoLink($_GET['buscaProduto']));
            $this->setViewParam('queryString', Paginacao::criandoQuerystring($_GET['paginacao'], $_GET['buscaProduto']));
            
            $this->setViewParam('listaProdutos', $listaProduto['resultado']);
    }

        $this->render('/produto/index');

        Sessao::limpaMensagem();
    }

}