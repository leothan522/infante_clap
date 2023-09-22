<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            Bloques Registrados
        </h3>

        <div class="card-tools">
            <!--<button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>-->
            <select class="custom-select custom-select-sm rounded-0" onchange="cambiarMunicipio()" id="bloques_select_municipios">
                <option value="">Seleccione Municipio</option>
                <option value="1">Infante</option>
                <option value="2">Camaguan</option>
            </select>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <div class="table-responsive mt-3">
            <table class="table" id="example1">
                <thead>
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>Número</th>
                    <th>Nombre</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($controller->listarBloques() as $bloque){
                    $i++;
                    ?>
                    <tr>
                        <td> <?php echo $i; ?> </td>
                        <td> <?php echo $bloque['numero']; ?></td>
                        <td> <?php echo $bloque['nombre']; ?> </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" onclick="editBloque(<?php echo $bloque['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info" >
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
    <!--<div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </div>-->
</div>