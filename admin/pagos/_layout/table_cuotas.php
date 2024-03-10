<?php
$listarCuotas = $controller->rows;
$i = $controller->offset;
$links = $controller->links;
?>
<div class="card-body">

    <div class="table table-sm mt-3">
        <table class="table" id="tabla_cuotas">
            <thead class="text-center">
            <tr>
                <th style="width: 15px">#</th>
                <th>Mes</th>
                <th>Fecha</th>
                <th style="width: 5%">&nbsp;</th>
            </tr>
            </thead>
            <tbody class="text-center">
            <?php
            foreach ($listarCuotas as $cuota) {
                $i++;
                ?>
                <tr id="tr_item_cuota_<?php echo $cuota['id']; ?>">
                    <td class="text-center item"><?php echo $i; ?>.</td>
                    <td class="mes"><?php echo mesEspanol($cuota['mes']) ?></td>
                    <td class="fecha"><?php echo verFecha($cuota['fecha']) ?></td>
                    <td>
                        <div class="btn-group btn-group-sm">

                            <button type="button" class="btn btn-info"
                                    onclick="editCuota(<?php echo $cuota['id']; ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-info"
                                    onclick="destroyCuota(<?php echo $cuota['id']; ?>)"
                                    id="btn_eliminar_cuota_<?php echo $cuota['id']; ?>">
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

<div class="card-footer clearfix col-12">
    <?php echo $links; ?>
    <!--<ul class="pagination pagination-sm m-0 float-right">
        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
    </ul>-->
</div>