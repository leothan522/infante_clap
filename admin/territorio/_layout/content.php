<div class="row">
    <div class="col-6">
        <div id="dataContainerMunicipio">
            <?php
            $listarMunicipios = $controller->listarMunicipios();
            $links = $controller->linksPaginate;
            $i = 0;
            require_once "card_table_municipios.php"
            ?>
        </div>

        <?php require_once "modal_municipios.php" ?>
    </div>
    <div class="col-6">
        <?php require_once "card_table_parroquias.php" ?>
        <?php require_once "modal_parroquias.php" ?>
    </div>
</div>