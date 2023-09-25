<div class="table-responsive mt-3">
    <table class="table" id="bloques_tabla">
        <thead>
        <tr>
            <th>Número</th>
            <th>Nombre</th>
            <th style="width: 5%">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($controller->listarBloques($id) as $bloque){
            ?>
            <tr id="tr_item_<?php echo $bloque['id']; ?>">
                <td class="numero"> <?php echo $bloque['numero']; ?></td>
                <td class="nombre"> <?php echo $bloque['nombre']; ?> </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-info" onclick="editBloque(<?php echo $bloque['id']; ?>)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-info" onclick="eliminarBloque(<?php echo $bloque['id']; ?>)" id="btn_eliminar_<?php echo $bloque['id']; ?>">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>