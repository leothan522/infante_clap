<!-- Modal -->
<div class="modal fade" aria-hidden="true" id="modal-entes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Gestionar Entes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $col = 12;
                    if (validarPermisos("entes.create")){
                    $col = 8;
                    ?>
                    <div class="col-md-4">
                        <?php require_once "form_entes.php" ?>
                    </div>
                    <?php } ?>

                    <div class="col-md-<?php echo $col; ?>" id="mostrar_entes">
                        <!--se cargara por JAVASCRITP-->
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
            <?php verCargando(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->