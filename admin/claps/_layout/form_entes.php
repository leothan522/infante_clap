<form id="entes_form">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title" id="title_form_ente">Crear Ente</h3>

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
                <label for="exampleInputPassword1">Nombre</label>
                <input type="text" class="form-control" placeholder="Nombre del Ente" name="entes_nombre" id="entes_input_nombre">
                <div class="invalid-feedback" id="error_entes_nombre"></div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="text" placeholder="id" name="id" id="entes_id">
            <input type="hidden"  name="opcion" value="guardar_ente" id="entes_opcion">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" onclick="limpiarBloques(false)" class="btn btn-default float-right">Cancel</button>
        </div>

    </div>
</form>