<div class="card card-outline card-primary">

    <div class="card-header">
        <h3 class="card-title">Parametros Registrados</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive  mt-3"
            <?php if ($limit > 15 && $totalRows > 15) {
                echo 'style="height: 54vh;"';
            }
            ?> >
            <table class="table table-sm" id="table_parametros">
                <thead>
                <tr>
                    <th style="width: 10%">#</th>
                    <th>Nombre</th>
                    <th>Tabla_id</th>
                    <th>Valor</th>
                    <th style="width: 10%;">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarParametros as $parametro){ ?>
                    <tr id="tr_item_<?php echo $parametro['id']; ?>">
                        <td><span class="text-bold"><?php echo ++$i; ?></span></td>
                        <td class="nombre">
                            <?php echo $parametro['nombre'] ?>
                        </td>
                        <td class="tabla_id">
                            <?php echo $parametro['tabla_id'] ?>
                        </td>
                        <td class="valor">
                            <?php echo $parametro['valor'] ?>
                        </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-info" onclick="edit(<?php echo $parametro['id'] ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-info" onclick="borrar(<?php echo $parametro['id']; ?>)" id="btn_eliminar_<?php echo $parametro['id'] ?>">
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
        <?php
        if (isset($linksPaginate)){
            echo $linksPaginate;
        }
         ?>
    </div>
        <?php verCargando(); ?>
</div>