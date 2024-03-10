<!-- Modal -->
<div class="modal fade" id="editar-jefe">
    <div class="modal-dialog modal-lm">
        <form id="form_edit_jefe">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="jefe_edit_title">Nombre del Jefe</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <?php require 'card_form_edit_jefe.php'; ?>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name="jefe_edit_id" placeholder="jefe_id" id="jefe_edit_id">
                        <input type="hidden" name="opcion" value="update_jefe">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                    <?php verCargando(); ?>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
