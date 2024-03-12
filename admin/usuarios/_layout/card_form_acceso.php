<form id="modal_acceso_form">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Configurar Acceso</h3>

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
        <div class="card-body">

            <div class="row">

                <div class="col-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Usuario</label>
                        <select class="select2bs4" name="usuario" data-placeholder="Seleccionar" id="usuarios_select_usuarios">
                            <!--JS-->
                        </select>
                        <div class="invalid-feedback" id="error_usuarios_select_usuarios"></div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Municipios</label>
                        <select class="select2bs4" name="municipios[]" multiple="multiple" data-placeholder="Municipios" id="usuarios_select_municipios">
                            <!--JS-->
                        </select>
                        <div class="invalid-feedback" id="error_usuarios_select_municipios"></div>
                    </div>
                </div>

            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="hidden" name="opcion" value="update" id="opcion">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-default float-right" onclick="resetFormAcceso()" id="btn_reset_acceso_municipio">Cancelar</button>
        </div>
    </div>
</form>
