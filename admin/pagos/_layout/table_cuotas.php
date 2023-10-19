<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            Cuotas Registradas
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
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <table class="table" id="tabla_cuotas">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Mes</th>
                    <th class="text-center">Fecha de Inicio</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($controller->listarCuotas() as $cuota){
                    $i++;
                    ?>
                    <tr id="tr_item_cuota_<?php echo $cuota['id']; ?>">
                        <td class="text-center item"> <?php echo $i; ?>. </td>
                        <td class="mes text-uppercase"> <?php echo mesEspanol($cuota['mes']); ?> </td>
                        <td class="fecha text-uppercase text-center"> <?php echo verFecha($cuota['fecha']); ?> </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" onclick="editCuota(<?php echo $cuota['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info" onclick="destroyCuota(<?php echo $cuota['id']; ?>)">
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