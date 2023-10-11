<!-- Modal -->
<div class="modal fade" id="editar-clap">
    <div class="modal-dialog modal-lm">
        <form id="form_create_clap">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-uppercase" id="clap_edit_title">Nombre del CLAP</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <?php require 'card_form_edit_clap.php'; ?>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="text" name="id" placeholder="clap_id" id="clap_edit_id">
                    <input type="text" name="opcion" value="editar_clap">
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