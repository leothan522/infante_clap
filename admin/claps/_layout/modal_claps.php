<!-- Modal -->
<div class="modal fade" id="modal-claps">
    <div class="modal-dialog modal-lg">
        <form id="form_create_clap">
            <div class="modal-content">
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
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name="id" placeholder="clap_id" id="clap_id">
                        <input type="hidden" name="opcion" value="guardar_clap" id="clap_opcion">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                    <?php verCargando(); ?>
                </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->