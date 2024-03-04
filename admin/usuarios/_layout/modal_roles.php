<!-- Modal -->
<div class="modal fade" id="modal_roles_usuarios">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="modal_form_roles_usuario">
                <div class="modal-header bg-primary">
                    <div class="row col-12">
                        <div class="col-7">
                            <h4 class="modal-title">
                                Rol de Usuario
                            </h4>
                        </div>
                        <div class="col-md-4 justify-content-end">
                                <div class="input-group">
                                    <input type="text" name="nombre" class="form-control" placeholder="nombre" required id="modal_input_nombre">
                                </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" id="modal_li_rol_nombre">Nombre</li>
                            </ol>
                        </div>
                    </div>

                    <div class="row" id="html_roles_usuario">
                        <!--JS-->
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" placeholder="input_roles_id" name="id" id="modal_input_roles_id">
                    <input type="hidden" name="opcion" value="update">
                    <button type="button" class="btn btn-danger" onclick="destroyRol()"><i class="fas fa-trash-alt"></i></button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_role_btn_cerrar">Cancelar</button>
                </div>
                <?php verCargando(); ?>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->