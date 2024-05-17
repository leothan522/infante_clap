<!-- Modal -->
<div class="modal fade" aria-hidden="true" id="modal-show-claps">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="form_create_clap">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="clap_title">Gestionar CLAPS</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php require 'card_show_clap.php'; ?>
                        </div>

                        <div class="col-md-6">
                            <?php require 'card_show_jefe.php'; ?>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" placeholder="id_clap" id="show_id_clap">
                    <input type="hidden" placeholder="id_jefe" id="show_id_jefe">
                    <button type="button" class="btn btn-danger btn-sm"
                            onclick="destroyClap(0)"
                        <?php if (!validarPermisos("claps.destroy")) {
                            echo 'disabled';
                        } ?> >
                        <i class="fas fa-trash-alt"> </i> Eliminar CLAP
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
                <?php verCargando(); ?>
            </form>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->