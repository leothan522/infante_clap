<?php
$listarClaps = $controller->rows;
$i = $controller->offset;
$col_municipio = $controller->verMunicipio;
$idMunicipio = $controller->idMunicipio;
?>
<div class="table-responsive">
    <table class="table table-sm" id="tabla_claps">
        <thead>
        <tr>
            <th style="width: 5%; text-align: center">#</th>
            <?php if ($col_municipio) { ?>
                <th>Municipio</th>
            <?php } ?>
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
        foreach ($listarClaps as $clap) {
            $i++;

            $jefe = $controller->getJefe($clap['id']);
            $municipio = $controller->getMunicipio($clap['municipios_id']);
            $ver = true;
            if (!empty($idMunicipio)) {
                if ($idMunicipio != $clap['municipios_id']) {
                    $ver = false;
                }
            }


            if (validarAccesoMunicipio($municipio['id']) && $ver) {
                ?>
                <tr id="tr_item_claps_<?php echo $clap['id'] ?>">
                    <td class="text-center item"><?php echo $i; ?>.</td>
                    <?php if ($col_municipio) { ?>
                        <td class="nombre_municipio text-uppercase"> <?php echo $municipio['mini']; ?> </td>
                    <?php } ?>
                    <td class="nombre_clap text-uppercase"> <?php echo $clap['nombre']; ?> </td>
                    <td class="nombre_jefe text-uppercase"> <?php echo $jefe['nombre']; ?> </td>
                    <td class="text-right cedula"> <?php echo formatoMillares($jefe['cedula'], 0); ?> </td>
                    <td class="text-center telefono"> <?php echo $jefe['telefono']; ?> </td>
                    <td class="text-right familias"><?php echo formatoMillares($clap['familias'], 0); ?></td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#modal-show-claps"
                                    onclick="showClapJefe(<?php echo $clap['id']; ?>)"
                                    id="btn_elimiar_clap_<?php echo $clap['id'] ?>">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
            }
        } ?>
        </tbody>
    </table>
</div>