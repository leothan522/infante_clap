<form id="bloques_form">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title" id="title_form_bloque">Crear Bloque</h3>

            <div class="card-tools">
                <!--<button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
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
                </button>-->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Número</label>
                <input type="text" class="form-control" placeholder="Introduce el número" name="bloques_numero" id="bloques_input_numero">
                <div class="invalid-feedback" id="error_bloques_numero"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Nombre</label>
                <input type="text" class="form-control" placeholder="Introduce el nombre" name="bloques_nombre" id="bloques_input_nombre">
                <div class="invalid-feedback" id="error_bloques_nombre"></div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="hidden" name="id" id="id">
            <input type="hidden" placeholder="id" name="municipios_id" id="bloques_municipios_id">
            <input type="hidden"  name="opcion" value="guardar_bloque" id="opcion_id">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
    </div>
</form>