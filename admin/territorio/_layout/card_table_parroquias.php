<?php
$listarParroquias = $controller->rows;
$links = $controller->links;
$i = $controller->offset;
$x = 0;
?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <?php if (empty($controller->keyword)){ ?>
            Parroquias
            <?php }else{ ?>
                Resultados para la busqueda [ <strong class="text-danger"><?php echo $controller->keyword; ?></strong> ] en Parroquias
                <button type="button" class="btn btn-tool" onclick="reconstruirTablaParroquias()">
                    <i class="fas fa-times-circle"></i>
                </button>
            <?php } ?>
        </h3>

        <div class="card-tools">
            <?php if (isset($restablecer) && $restablecer){ ?>
            <button class="btn btn-tool d-none" onclick="filtrarParroquias('')" id="parroquias_btn_restablecer">
                <i class="fas fa-sync-alt"></i> Reestablacer
            </button>
            <?php } ?>
            <button class="btn btn-tool" data-toggle="modal"
                    onclick="resetParroquia()"
                    data-target="#modal-parroquias"
                    <?php if (!validarPermisos('parroquias.create')){ echo 'disabled'; } ?> >
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table table-responsive mt-3">
            <table class="table table-sm" id="tabla_parroquias">
                <thead>
                <tr>
                    <th style="width: 15px">#</th>
                    <th>Nombre</th>
                    <th class="text-right">Asignación</th>
                    <th class="text-center">Municipio</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarParroquias as $parroquia) {
                    $i++;
                    $x++;
                    ?>
                    <tr id="tr_item_p_<?php echo $parroquia['id']; ?>">
                        <td class="text-center item"><?php echo $i; ?>. </td>
                        <td class="parroquia"><?php echo $parroquia['nombre']; ?></td>
                        <td class="asignacion text-right"><?php echo formatoMillares($parroquia['familias'], 0) ?></td>
                        <td class="municipio text-center">
                            <?php echo $controller->getMunicipio($parroquia['municipios_id']); ?>
                        </td>
                        <td class="botones">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info"
                                        onclick="estatusParroquia(<?php echo $parroquia['id']; ?>)"
                                        id="btn_estatus_parroquia_<?php echo $parroquia['id']; ?>"
                                        <?php if (!validarPermisos('parroquias.estatus')){ echo 'disabled'; } ?> >
                                    <?php if ($parroquia['estatus']){ ?>
                                        <i class="fas fa-eye"></i>
                                    <?php }else{ ?>
                                        <i class="fas fa-eye-slash"></i>
                                    <?php } ?>
                                </button>

                                <button type="button" class="btn btn-info"
                                        onclick="editParroquia(<?php echo $parroquia['id']; ?>)" data-toggle="modal"
                                        data-target="#modal-parroquias"
                                        <?php if (!validarPermisos('parroquias.edit')){ echo 'disabled'; } ?> >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info"
                                        onclick="elimParroquia(<?php echo $parroquia['id']; ?>)"
                                        id="btn_eliminar_p_<?php echo $parroquia['id']; ?>"
                                        <?php if (!validarPermisos('parroquias.destroy')){ echo 'disabled'; } ?> >
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <?php
        if (empty($controller->keyword)){
            echo $links;
        }else{
            echo "Mostrando ".$x;
        }
        ?>

        <input type="hidden" value="<?php echo $x; ?>" id="input_hidden_parroquia_valor_x">
    </div>
    <?php verCargando(); ?>
</div>