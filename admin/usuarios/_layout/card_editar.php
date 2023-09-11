<form id="form_editar_user">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Datos a Editar</h3>

            <!--<div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>-->
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body pt-5">


            <label for="edit_name">Nombre</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Nombre completo" name="name" id="edit_name">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_edit_name"></div>
            </div>

            <label for="edit_email">Email</label>
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email" id="edit_email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_edit_email"></div>
            </div>

            <label for="edit_telefono">Teléfono</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Número de teléfono" name="telefono" id="edit_telefono">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_edit_telefono"></div>
            </div>

            <label for="edit_tipo">Tipo</label>
            <div class="input-group mb-3">

                <select class="custom-select rounded-0" name="tipo" id="edit_tipo">
                    <option value="">Seleccione</option>
                    <option value="0">Usuario Público</option>
                    <option value="1">Usuario Estandar</option>
                    <option value="99">Usuario Administrador</option>
                </select>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>

                <div class="invalid-feedback" id="error_edit_tipo"></div>
            </div>


        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="hidden" name="opcion" value="editar" id="edit_opcion">
            <input type="hidden" name="id" id="edit_id">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <button type="reset" class="btn btn-default float-right" onclick="getUser()" id="btn_edit_cancelar">Restablecer</button>
        </div>
    </div>
</form>