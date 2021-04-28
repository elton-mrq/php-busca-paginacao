<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Editar Produto</h3>
            <hr>
            <?php if($Sessao::retornaErro()) {?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php foreach($Sessao::retornaErro() as $key => $mensagem) { echo $mensagem . '<br>';} ?>
                </div>
            <?php }?>

            <form action="http://<?php echo APP_HOST; ?>/produto/atualizar/<?php echo $viewVar['queryString']; ?>" method="POST" id="form_cadastro">
                <input type="hidden" class="form-control" name="id" value="<?php echo $viewVar['produto']->getId(); ?>">

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" value="<?php echo $viewVar['produto']->getNome(); ?>" name="nome">
                </div>

                <div class="form-group">
                    <label for="preco">Preço:</label>
                    <input type="text" class="form-control money" value="<?php echo $ConversorMonetario::dolarParaReal($viewVar['produto']->getPreco()); ?>" name="preco" maxlength="11">
                </div>

                <div class="form-group">
                    <label for="unidade">Unidade</label>
                    <select name="unidade" id="" class="form-control">
                        <option value="Caixa" <?php echo ($viewVar['produto']->getUnidade() == "Caixa") ? "select" : ""; ?>>Caixa</option>
                        <option value="Pacote" <?php echo ($viewVar['produto']->getUnidade() == "Pacote") ? "select" : ""; ?>>Pacote</option>
                        <option value="Unidade" <?php echo ($viewVar['produto']->getUnidade() == "Unidade") ? "select" : ""; ?>>Unidade</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ean">EAN:</label>
                    <input type="text" class="form-control" value="<?php echo $viewVar['produto']->getEan(); ?>" name="ean">
                </div>

                <div class="form-group">
                    <label for="status_s">Ativo</label>
                    <input type="radio" name="status" id="status_s"  class="form-check-input" value="S" <?php echo ($viewVar['produto']->getStatus() == 'S') ? "checked" : "" ?>>
                    <label for="status_n">Inativo</label>
                    <input type="radio" name="status" id="status_n" class="form-check-input" value="N" <?php echo ($viewVar['produto']->getStatus() == 'N') ? "checked" : "";?>>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" name="descricao" placeholder="Descrição do produto" required><?php echo $viewVar['produto']->getDescricao(); ?></textarea>
                </div>


                <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Salvar </button>
                <a href="http://<?php echo APP_HOST; ?>/produto/<?php echo $viewVar['queryString']; ?>" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-arrow-lefth" aria-hidden="true"></span> Voltar </a>

            </form>
        </div>
    </div>
</div>