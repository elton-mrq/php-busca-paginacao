<?php

namespace App\Models\DAO;

use App\Models\Entidades\Produto;
use Exception;

class ProdutoDAO extends BaseDAO
{

    public function __construct()
    {
        parent::__construct('produto');
    }

    public function buscaComPaginacao($buscaProduto, $totalPorPagina, $paginaSelecionada)
    {
        $paginaSelecionada = (!$paginaSelecionada) ? 1 : $paginaSelecionada;

        $inicio = (($paginaSelecionada - 1) * $totalPorPagina);

        $whereBusca = "nome 
                            LIKE '%{$buscaProduto}%' OR descricao 
                            LIKE '%{$buscaProduto}%' OR ean = '{$buscaProduto}'
                        ";

        $resultadoTotal = $this->select($whereBusca, null, null, 'count(*) as total');

        $resultado = $this->select($whereBusca, null, $inicio .','. $totalPorPagina)->fetchAll(\PDO::FETCH_CLASS, Produto::class);

        $totalLinhas = $resultadoTotal->fetch()['total'];

        return ['paginaSelecionada'         => $paginaSelecionada,
                'totalPorPagina'            => $totalPorPagina,
                'totalLinhas'               => $totalLinhas,
                'resultado'                 => $resultado
            ];

    }

    public function validaEan($ean)
    {
        if($ean){
            $resultado = $this->select("ean = '{$ean}'", null, null, 'count(*) as total');
            return $resultado->fetch()['total'];
        }else{
            return false;
        }

        return false;
    }

    public function listar($id = null)
    {
        if($id){
            $resultado = $this->select(" id = {$id}");

            return $resultado->fetchObject(Produto::class);
        } else {
            $resultado = $this->select();

            return $resultado->fetchAll(\PDO::FETCH_CLASS, Produto::class);

        }
        return false;
    }

    public function salvar(Produto $produto)
    {
        try {
            $nome           = $produto->getNome();
            $status         = $produto->getStatus();
            $preco          = $produto->getPreco();
            $unidade        = $produto->getUnidade();
            $ean            = $produto->getEan();
            $descricao      = $produto->getDescricao();

            return $this->insert(
                                    [
                                        'nome'          => $nome,
                                        'status'        => $status,
                                        'preco'         => $preco,
                                        'unidade'       => $unidade,
                                        'ean'           => $ean,
                                        'descricao'     => $descricao 
                                    ]
            );

        } catch (Exception $exc) {
            throw new Exception("Erro na gravação de dados. " .$exc->getMessage(), 500);
        }
    }

    public function atualizar(Produto $produto)
    {
        try {
            $id             = $produto->getId();
            $nome           = $produto->getNome();
            $status         = $produto->getStatus();
            $preco          = $produto->getPreco();
            $unidade        = $produto->getUnidade();
            $ean            = $produto->getEan();
            $descricao      = $produto->getDescricao();

            return $this->update("id = {$id}",
                                [
                                    'nome'          => $nome,
                                    'status'        => $status,
                                    'preco'         => $preco,
                                    'unidade'       => $unidade,
                                    'ean'           => $ean,
                                    'descricao'     => $descricao
                                ]
            );

        } catch (Exception $exc) {
            throw new Exception($exc->getMessage(), 500);
        }
    }

    public function excluir(Produto $produto)
    {
        try {
            $id = $produto->getId();

            return $this->delete("id = {$id}");

        } catch (Exception $exc) {
            throw new Exception("Erro ao excluir o produto", 500);
        }
    }

}