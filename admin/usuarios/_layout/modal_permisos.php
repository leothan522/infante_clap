<!-- Modal -->
<div class="modal fade" id="modal_permisos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_permisos_usuario">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Permisos de Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" id="li_permisos_nombre">Nombre</li>
                                <li class="breadcrumb-item active" id="li_permisos_email">Email</li>
                                <li class="breadcrumb-item active" id="li_permisos_role">Tipo Usuario</li>
                            </ol>
                        </div>
                    </div>

                    <div class="row" id="html_permisos_usuario">
                        <!--JS-->
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" placeholder="input_permisos_id" name="id" id="input_permisos_id">
                    <input type="hidden" name="opcion" value="set_permisos">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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