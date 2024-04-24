<?php
$listarBancos = $controller->rows;
$i = $controller->offset;
$links = $controller->links;
$valor_x = 0;
?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Bancos Registrados</h3>

    </div>
    <!-- /.card-header -->
    <div class="card-body" id="card_body_bancos">
        <div class="table">
            <table class="table table-sm" id="table_bancos">
                <thead>
                <tr class="text-center">
                    <th style="width: 10px">#</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
               <?php
                foreach ($listarBancos as $banco){
                    $i++;
                    $valor_x++;
                ?>
                <tr id="tr_item_<?php echo $banco['id']; ?>">

                    <td class="text-center"><span class="text-bold"><?php echo $i; ?></span></td>

                    <td class="nombre_banco">
                        <?php echo $banco['nombre']; ?>
                    </td>

                    <td class="codigo_banco text-center">
                       <?php echo $banco['codigo']; ?>
                    </td>

                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-info"
                                    onclick="editBanco(<?php echo $banco['id']; ?>)" >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-info"
                                    onclick="destroyBanco(<?php echo $banco['id']; ?>)"
                                    id="btn_eliminar_banco_<?php echo $banco['id']; ?>">
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
        <input type="hidden" value="<?php echo $valor_x; ?>"  id="input_hidden_valor_x">
    </div>
</div>
