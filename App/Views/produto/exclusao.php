<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Excluir Produto</h3>

            <?php if($Sessao::retornaErro()) { ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php foreach($Sessao::retornaErro() as $key => $mensagem) { echo $mensagem . '<br>'; } ?>
                </div>
            <?php } ?>

            <form action="http://<?php echo APP_HOST ?>/produto/excluir" method="post" id="form_cadastro">
                <input type="hidden" name="id" value="<?php echo $viewVar['produto']->getId() ?>" class="form-control">

                <div class="panel panel-danger">
                    <div class="panel-body">
                        <h4>Deseja realmente excluir o produto: <?php echo $viewVar['produto']->getNome(); ?>?</h4>
                    </div>
                </div>

                <div class="panel-footer">
                    <button class="btn btn-danger btn-sm" type="submit">Excluir</button>
                    <a href="http://<?php echo APP_HOST; ?>/produto/<?php echo $viewVar['queryString']; ?>" class="btn btn-info btn-sm">Voltar</a>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>             
    </div>
</div>