<?php
$listarMunicipios = $controller->rows;
$links = $controller->links;
$i = $controller->offset;
$x = 0;
?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <?php if (empty($controller->keyword)){ ?>
            Municipios
            <?php }else{ ?>
                Resultados para la busqueda [ <strong class="text-danger"><?php echo $controller->keyword; ?></strong> ] en Municipios
                <button type="button" class="btn btn-tool" onclick="reconstruirTabla()">
                    <i class="fas fa-times-circle"></i>
                </button>
            <?php } ?>
        </h3>

        <div class="card-tools">
            <button class="btn btn-tool"
                    onclick="resetMunicipio()" data-toggle="modal"
                    data-target="#modal-municipios"
                    <?php if (!validarPermisos('municipios.create')){ echo 'disabled'; } ?> >
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table table-responsive">
            <table class="table table-sm" id="tabla_municipios">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nombre</th>
                    <th>Abreviatura</th>
                    <th style="width: 40px">Asignación</th>
                    <th style="width: 40px">Parroquias</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarMunicipios as $municipio) {
                    $i++;
                    $x++;
                    ?>
                    <tr id="tr_item_<?php echo $municipio['id']; ?>">
                        <td class="text-center item"><?php echo $i; ?>.</td>
                        <td class="nombre text-uppercase"><?php echo $municipio['nombre']; ?></td>
                        <td class="mini text-uppercase"><?php echo $municipio['mini']; ?></td>
                        <td class="asignacion text-right"> <?php echo formatoMillares($municipio['familias'], 0); ?> </td>
                        <td class="text-center parroquias">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-success" onclick="filtrarParroquias(<?php echo $municipio['id'] ?>)"
                                id="btn_count_parroquias_<?php echo $municipio['id'] ?>">
                                    <?php echo formatoMillares($controller->countParroquias($municipio['id']), 0); ?>
                                </button>
                            </div>
                        </td>

                        <td class="botones">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info"
                                        onclick="estatusMunicipio(<?php echo $municipio['id']; ?>)"
                                        id="btn_estatus_mun_<?php echo $municipio['id']; ?>"
                                        <?php if (!validarPermisos('municipios.estatus')) {
                                        echo 'disabled';
                                    } ?> >
                                    <?php if ($municipio['estatus']) { ?>
                                        <i class="fas fa-eye"></i>
                                    <?php } else { ?>
                                        <i class="fas fa-eye-slash"></i>
                                    <?php } ?>
                                </button>
                                <button type="button" class="btn btn-info"
                                        onclick="editMunicipio(<?php echo $municipio['id']; ?>)" data-toggle="modal"
                                        data-target="#modal-municipios"
                                        <?php if (!validarPermisos('municipios.edit')){ echo 'disabled'; } ?> >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info"
                                        onclick="destroyMunicipio(<?php echo $municipio['id'] ?>)"
                                        id="btn_eliminar_<?php echo $municipio['id']; ?>"
                                        <?php if (!validarPermisos('municipios.destroy')){ echo 'disabled'; } ?>>
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
        <!--<ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>-->
    </div>
    <?php verCargando(); ?>
</div>