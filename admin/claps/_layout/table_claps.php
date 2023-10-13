<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Claps Registrados</h3>

        <div class="card-tools">
            <button class="btn btn-tool" data-toggle="modal" onclick="resetClap('clap_create_select_municipio', 'clap_create_select_entes')" data-target="#modal-claps">
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive mt-3">
            <table class="table" id="tabla_claps">
                <thead>
                <tr>
                    <th style="width: 5%; text-align: center">#</th>
                    <th>Nombre del CLAPS</th>
                    <th>Jefe de Comunidad</th>
                    <th class="text-right">Cédula</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-right">Familias</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarClap as $clap) {
                    $i++;
                    $jefe = getJefe($clap['id']);
                    ?>
                    <tr id="tr_item_claps_<?php ?>">
                        <td class="text-center item"><?php echo $i; ?></td>
                        <td class="nombre_clap text-uppercase"> <?php echo $clap['nombre']; ?> </td>
                        <td class="nombre_jefe text-uppercase"> <?php echo $jefe['nombre']; ?> </td>
                        <td class="text-right cedula"> <?php echo formatoMillares($jefe['cedula'], 0); ?> </td>
                        <td class="text-center telefono"> <?php echo $jefe['telefono']; ?> </td>
                        <td class="text-right familias"><?php echo formatoMillares($clap['familias'], 0); ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" onclick="">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-info" data-toggle="modal" onclick="editClap(<?php echo $clap['id']; ?>)" data-target="#editar-clap">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info" data-toggle="modal" onclick="editJefe(<?php echo $jefe['id']; ?>)" data-target="#editar-jefe">
                                    <i class="fas fa-user-edit"></i>
                                </button>

                                <button type="button" class="btn btn-info"
                                        onclick="destroyClap(<?php echo $clap['id'] ?>)"
                                        id="btn_eliminar_<?php echo $clap['id']; ?>">
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
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </div>
</div>