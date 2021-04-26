<?php

namespace App\Controllers;

use App\Lib\ConversorMonetario;
use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Models\DAO\ProdutoDAO;
use App\Models\Entidades\Produto;
use App\Models\Validacao\ProdutoValidator;

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

    public function cadastro()
    {
        $this->render('/produto/cadastro');

        Sessao::limpaErro();
        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
    }

    public function salvar()
    {
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $produto = new Produto();

            $produto->setNome($_POST['nome']);
            $produto->setStatus($_POST['status']);
            $produto->setPreco(ConversorMonetario::realParaDolar($_POST['preco']));
            $produto->setUnidade($_POST['unidade']);
            $produto->setEan($_POST['ean']);
            $produto->setDataCadastro($_POST['descricao']);

            Sessao::gravaFormulario($_POST);

            $produtoValidator = new ProdutoValidator();
            $resultadoValidacao = $produtoValidator->validar($produto);
            $erros = $resultadoValidacao->getErros();

            if($erros){
                Sessao::gravaErro($erros);
                $this->redirect('/produto/cadastro');
            }
            
            $produtoDAO = new ProdutoDAO();

            if($produtoDAO->validaEan($produto->getEan())){
                Sessao::gravaErro(['Código EAN já existe.']);
                $this->redirect('/produto/cadastro');
            }

            $produtoDAO->salvar($produto);

            $this->redirect('/produto');

        } else {
            Sessao::gravaErro(['Não tem POST']);
            $this->redirect('/produto/cadastro');
        }          
        
        Sessao::limpaErro();
        Sessao::limpaFormulario();
        Sessao::limpaMensagem();

    }

    public function edicao($params)
    {
        if($params){

            $id = $params[0];

            $produtoDAO = new ProdutoDAO();

            $produto = $produtoDAO->listar($id);

            if(!$produto){
                Sessao::gravaMensagem('Produto Inexistente!');
                $this->redirect('/produto');
            }

            $this->setViewParam('produto', $produto);
            $this->setViewParam('queryString', Paginacao::criandoQuerystring($_GET['paginaSelecionada'], $_GET['buscaProduto']));

            $this->render('/produto/editar');

            Sessao::limpaErro();
            Sessao::limpaMensagem();

        }else{
            throw new \Exception("Erro na aplicação", 404);
        }
    }

    public function atualizar()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $produto = new Produto();
            $produto->setId($_POST['id']);
            $produto->setNome($_POST['nome']);
            $produto->setStatus($_POST['status']);
            $produto->setPreco($_POST['preco']);
            $produto->setPreco(ConversorMonetario::realParaDolar($_POST['preco']));
            $produto->setUnidade($_POST['unidade']);
            $produto->setEan($_POST['ean']);
            $produto->setDescricao($_POST['descricao']);

            Sessao::gravaFormulario($_POST);

            $produtoValidator = new ProdutoValidator();
            $resultadoValidacao = $produtoValidator->validar($produto);

            if($resultadoValidacao->getErros()){
                Sessao::gravaErro($resultadoValidacao->getErros());
                $this->redirect('/produto/edicao/' . $_POST['id']);
            }

            $produtoDAO = new ProdutoDAO();

            $produtoSelecionado = $produtoDAO->listar($produto->getId());

            if($produtoDAO->validaEan($produto->getEan()) &&
                $produtoSelecionado->getEan() != $produto->getEan()){
                    Sessao::gravaErro(['Código EAN incorreto!']);
                    $this->redirect('/produto/edicao/' . $_POST['id'] . '?buscaProduto=' . $_GET['buscaProduto'] . '&paginaSelecionada=' . $_GET['paginaSelecionada']);
                }
            
            $produtoDAO->atualizar($produto);

            Sessao::limpaErro();
            Sessao::limpaMensagem();
            Sessao::limpaFormulario();

        } else {
            throw new \Exception('Erro na aplicação.', 404);
        }
    }

}
