<?php
$permisos = verPermisos();

echo $permisos[0];

/*if ($_POST){

    $contador = $_POST['contador'];

    $permisos = array();

    for ($i = 1; $i <= $contador; $i++){

        if (isset($_POST['permiso_'.$i])){
            $permiso = $_POST['permiso_'.$i];
            $permisos[] = $permiso;
        }

    }

    echo json_encode(crearJson($permisos));

}*/


?>

<!--<div class="col-md-4">
    <div class="card card-primary card-outline collapsed-card">
        <div class="card-header">
            <h3 class="card-title">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="checkbox_modulo_"
                           value="usuarios.index">
                    <label for="checkbox_modulo_" class="custom-control-label">
                        Nombre Modulo
                    </label>
                </div>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input custom-control-input-primary custom-control-input-outline"
                           type="checkbox" id="checkbox_permiso_1" value="">
                    <label for="checkbox_permiso_1" class="custom-control-label">
                        Nombre Permiso 1
                    </label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input custom-control-input-primary custom-control-input-outline"
                           type="checkbox" id="checkbox_permiso_2">
                    <label for="checkbox_permiso_2" class="custom-control-label">
                        Nombre Permiso 2
                    </label>
                </div>
            </div>

        </div>
    </div>
</div>-->
