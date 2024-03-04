<div class="row">
    <div class="col-md-6">
        <div id="dataContainerMunicipio">
            <?php
            $controller->index();
            require_once "card_table_municipios.php"
            ?>
        </div>

        <?php require_once "modal_municipios.php" ?>
    </div>
    <div class="col-md-6">
        <div id="dataContainerParroquia">
            <?php
            $controller->index('parroquias');
            require_once "card_table_parroquias.php"
            ?>
        </div>
        <?php require_once "modal_parroquias.php" ?>
    </div>
</div>