<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Accesos Registrados </h3>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table">
            <table class="table" id="usuario_table_acceso">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Usuario</th>
                    <th>Municipios</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarUsuarios as $user){
                    $i++;
                    if (!empty($user['acceso_municipio'])) {
                        $municipios = json_decode($user['acceso_municipio']);
                    }else{
                        $municipios = [];
                    }
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $user['name'] ?></td>
                        <td>
                            <?php foreach ($municipios as $municipio => $opcional){ ?>
                                <span class="text-sm"><?php echo $controller->getMunicipio($municipio).", " ?></span>
                            <?php } ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" id="btn_eliminar_<?php echo $user['id'] ?>">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php

                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <?php echo $links ?>
    </div>
</div>