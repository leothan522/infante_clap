<!-- Modal -->
<div class="modal fade" id="modal-cuotas">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Gestionar Cuotas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <?php require "form_cuotas.php" ?>
                    </div>
                    <div class="col-md-8">
                        <div id="dataContainerCuotas">
                            <?php
                            $listarCuotas = $controller->listarCuotas();
                            $i = 0;
                            $links = $controller->linksPaginate;
                            require 'table_cuotas.php';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            <?php verCargando(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->