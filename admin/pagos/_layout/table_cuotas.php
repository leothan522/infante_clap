<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            Entes Registrados
        </h3>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table">
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
                foreach ($listarCuotas as $cuota) {
                    $i++;
                    ?>
                    <tr id="tr_item_cuota_<?php echo $cuota['id']; ?>">
                        <td class="text-center item"> <?php echo $i; ?>.</td>
                        <td class="mes text-uppercase"> <?php echo mesEspanol($cuota['mes']); ?> </td>
                        <td class="fecha text-uppercase text-center"> <?php echo verFecha($cuota['fecha']); ?> </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info"
                                        onclick="editCuota(<?php echo $cuota['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info"
                                        id="btn_eliminar_(<?php echo $cuota['id']; ?>)"
                                        onclick="destroyCuota(<?php echo $cuota['id']; ?>)" >
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
    </div>

</div>