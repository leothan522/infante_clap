<div class="row">
    <div class="col-12">
        <?php
        use app\model\Jefe;
       $listarClap = $controller->listarClaps();

       function getJefe($id)
        {
            $model = new Jefe();
            $jefe = $model->first('claps_id', '=', $id);
            return $jefe;
        }
            $i = 0;
            require "table_claps.php";
            ?>
    </div>


</div>
<?php require_once "modal_claps.php" ?>
<?php require_once "modal_bloques.php" ?>
<?php require_once "modal_entes.php" ?>
<?php require_once 'editar_jefe.php' ?>
<?php require_once 'editar_clap.php'; ?>


