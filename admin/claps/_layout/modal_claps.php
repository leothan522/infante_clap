<!-- Modal -->
<div class="modal fade" id="modal-claps">
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
                        <?php require 'card_form_clap.php'; ?>
                    </div>

                    <div class="col-md-6">
                        <?php require 'card_form_jefe.php'; ?>
                    </div>

                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="hidden" name="opcion" value="store">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
            <?php verCargando(); ?>
            </form>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->