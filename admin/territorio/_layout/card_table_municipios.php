<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Municipios</h3>

        <div class="card-tools">
            <button class="btn btn-tool" onclick="resetMunicipio()" data-toggle="modal" data-target="#modal-municipios">
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table mt-3">
            <table class="table" id="tabla_municipios">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nombre</th>
                    <th>Abreviatura</th>
                    <th style="width: 40px">Parroquias</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarMunicipios as $municipio){
                    $i++;
                ?>
                    <tr id="tr_item_<?php echo $municipio['id']; ?>">
                        <td class="text-center item"><?php echo $i; ?>.</td>
                        <td class="nombre text-uppercase"><?php echo $municipio['nombre']; ?></td>
                        <td class="mini text-uppercase"><?php echo $municipio['mini']; ?></td>
                        <td class="text-center parroquias">
                            <div class="btn-group btn-group-sm parroquia">
                                <button type="button" class="btn btn-success" onclick="filtrarParroquias(<?php echo $municipio['id'] ?>)">
                                    <?php echo formatoMillares($municipio['parroquias'], 0); ?>
                                </button>
                            </div>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" onclick="estatusMunicipio(<?php echo $municipio['id']; ?>)" id="btn_estatus_<?php echo $municipio['id']; ?>">
                                    <?php if ($municipio['estatus']){ ?>
                                        <i class="fas fa-eye"></i>
                                    <?php }else{ ?>
                                        <i class="fas fa-eye-slash"></i>
                                    <?php } ?>
                                </button>
                                <button type="button" class="btn btn-info" onclick="editMunicipio(<?php echo $municipio['id']; ?>)" data-toggle="modal" data-target="#modal-municipios">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info" onclick="destroyMunicipio(<?php echo $municipio['id'] ?>)" id="btn_eliminar_<?php echo $municipio['id']; ?>">
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
        <?php echo $links; ?>
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