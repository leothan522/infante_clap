<div class="row">
    <div class="col-12">
        <div id="">
            <?php
            /*use app\model\Jefe;
            function getJefe($id)
            {
                $model = new Jefe();
                $jefe = $model->first('claps_id', '=', $id);
                return $jefe;
            }
            $listarClap = $controller->listarClaps();
            $i = 0;
            $links = $controller->linksPaginate;*/
            require "card_listar_claps.php";
            ?>
        </div>
    </div>


</div>
<?php require_once "modal_claps.php" ?>
<?php require_once "modal_bloques.php" ?>
<?php require_once "modal_entes.php" ?>
<?php require_once 'editar_jefe.php' ?>
<?php require_once 'editar_clap.php'; ?>
<?php require_once 'modal_show_claps.php'; ?>


