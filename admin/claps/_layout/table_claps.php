<div class="" id="dataContainerClap">
    <table class="table table-sm" id="tabla_claps">
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
            <tr id="tr_item_claps_<?php echo $clap['id'] ?>">
                <td class="text-center item"><?php echo $i; ?>.</td>
                <td class="nombre_clap text-uppercase"> <?php echo $clap['nombre']; ?> </td>
                <td class="nombre_jefe text-uppercase"> <?php echo $jefe['nombre']; ?> </td>
                <td class="text-right cedula"> <?php echo formatoMillares($jefe['cedula'], 0); ?> </td>
                <td class="text-center telefono"> <?php echo $jefe['telefono']; ?> </td>
                <td class="text-right familias"><?php echo formatoMillares($clap['familias'], 0); ?></td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-show-claps"
                                onclick="showClapJefe(<?php echo $clap['id']; ?>)" id="btn_elimiar_clap_<?php echo $clap['id'] ?>">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>