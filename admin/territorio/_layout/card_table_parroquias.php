
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Parroquias</h3>

        <div class="card-tools">
            <a href="./" class="btn btn-tool d-none" id="parroquias_btn_restablecer">
                <i class="fas fa-sync-alt"></i> Reestablacer
            </a>
            <button class="btn btn-tool" data-toggle="modal" onclick="resetParroquia()" data-target="#modal-parroquias">
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table mt-3">
            <table class="table" id="tabla_parroquias">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nombre</th>
                    <th>Abreviatura</th>
                    <th>Municipio</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarParroquias as $parroquia) {
                    $i++;
                    ?>
                    <tr id="tr_item_p_<?php echo $parroquia['id']; ?>">
                        <td class="text-center item"><?php echo $i; ?>. </td>
                        <td class="parroquia"><?php echo $parroquia['nombre']; ?></td>
                        <td class="mini"><?php echo $parroquia['mini']; ?></td>
                        <td class="municipio">
                            <?php echo $controller->getMunicipio($parroquia['municipios_id']); ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" onclick="estatusParroquia(<?php echo $parroquia['id']; ?>)" id="btn_estatus_parroquia_<?php echo $parroquia['id']; ?>">
                                    <?php if ($parroquia['estatus']){ ?>
                                        <i class="fas fa-eye"></i>
                                    <?php }else{ ?>
                                        <i class="fas fa-eye-slash"></i>
                                    <?php } ?>
                                </button>

                                <button type="button" class="btn btn-info" onclick="editParroquia(<?php echo $parroquia['id']; ?>)" data-toggle="modal"
                                        data-target="#modal-parroquias">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info" onclick="elimParroquia(<?php echo $parroquia['id']; ?>)" id="btn_eliminar_p_<?php echo $parroquia['id']; ?>">
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