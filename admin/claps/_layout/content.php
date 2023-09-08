<div class="row">
    <div class="col-12">
        <div class="dataContainerClap">
            <?php
            use app\model\Jefe;
            function getJefe($id)
            {
                $model = new Jefe();
                $jefe = $model->first('claps_id', '=', $id);
                return $jefe;
            }
            $listarClap = $controller->listarClaps();
            $i = 0;
            $links = $controller->linksPaginate;
            require "table_claps.php";
            ?>
        </div>
    </div>


</div>
<?php require_once "modal_claps.php" ?>
<?php require_once "modal_bloques.php" ?>
<?php require_once "modal_entes.php" ?>
<?php require_once 'editar_jefe.php' ?>
<?php require_once 'editar_clap.php'; ?>


