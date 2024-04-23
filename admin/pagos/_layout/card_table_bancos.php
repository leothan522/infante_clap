<?php
use app\controller\BancosController;
$controllerBanco = new BancosController();
$controllerBanco->index();
$listarBancos = $controllerBanco->rows;
$i = $controllerBanco->offset;
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
                <tr style="text-align: center;">
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
                ?>
                <tr id="tr_item_banco_<?php echo $banco['id']; ?>" style="text-align: center;">

                    <td><span class="text-bold"><?php echo $i; ?></span></td>

                    <td class="nombre_banco">
                        <?php echo $banco['nombre']; ?>
                    </td>

                    <td class="codigo_banco">
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
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </div>
</div>
