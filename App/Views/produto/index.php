<div class="container">
    <div class="row">
        <div class="col-md-6">
            <a href="http://<?php echo APP_HOST; ?>/produto/cadastro" class="btn btn-sucess"><span class="glyphicon glyphicon-plus" aria-hidden="true">Adicionar</span></a>
        </div>

        <div class="col-md-6">
            <form action="http://<?php echo APP_HOST; ?>/produto/" method="get" class="form-inline buscaDireita">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon input-sm" id="basic-addon1">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </span>
                        <input type="text" name="buscaProduto" class="form-control input-sm" placeholder="Buscar conteúdo" value="<?php echo $viewVar['buscaProduto']; ?>">
                        <div class="input-group-btn">
                            <button class="btn btn-success btn-sm" type="submit">Buscar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="col-md-12 col-lg-12">
            <hr>

            <?php 
                if(is_null($viewVar['listaProdutos'])){
            ?>
                    <div class="alert alert-info" role="alert">Efetue uma busca para exibir o seu produto.</div>
            <?php
                } else {
            ?>
                    <?php if($Sessao::retornaMensagem()){ ?>
                        <div class="alert alert-warning" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>
                    <?php } ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="info">Nome</th>
                                    <th class="info hidden-sm hidden-xs">Preço</th>
                                    <th class="info hidden-sm hidden-xs">EAN</th>
                                    <th class="info hidden-sm hidden-xs">Status</th>
                                    <th class="info hidden-sm hidden-xs">Data Cadastro</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($viewVar['listaProdutos'] as $produto) { ?>
                                <tr class="<?php echo ($produto->getStatus = "N") ? "linhaDesativado" : ""; ?>">
                                    <td><?php echo $produto->getNome(); ?></td>
                                    <td class="hidden-sm hidden-xs">R$ <?php // echo App\Lib\ConversorMonetario::dolarParaReal($produto->getPreco()); ?></td>
                                    <td class="hidden-sm hidden-xs"><?php echo $produto->getEan(); ?></td>
                                    <td class="hidden-sm hidden-xs"><?php echo $produto->getStatus(); ?></td>
                                    <td class="hidden-sm hidden-xs"><?php echo $produto->getDataCadastro()->format('d/m/Y'); ?></td>
                                    <td>
                                        <a href="http://<?php echo APP_HOST; ?>/produto/edicao/<?php echo $produto->getId(); ?><?php echo $viewVar['queryString']; ?>" class="btn btn-info btn-sm" <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar </a>
                                        <a href="http://<?php echo APP_HOST; ?>/produto/exclusao/<?php echo $produto->getId(); ?><?php echo $viewVar['queryString']; ?>" class="btn btn-danger btn-sm" <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Editar </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php // echo $viewVar['paginacao'] ?>
                    <?php } ?>
        </div>
    </div>
</div>