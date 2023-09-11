<form id="form_parametros">
    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title">Crear Parámetros</h3>

            <div class="card-tools">
                <!--<button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>-->
                <button type="button" class="btn btn-tool" data-card-widget="remove" onclick="ocultarForm()" id="ocultar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" class="form-control" placeholder="Nombre" name="name" id="name">
                <div class="invalid-feedback" id="error_name"></div>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Tabla_id</label>
                <input type="text" class="form-control" placeholder="Tabla_id" name="tabla_id" id="tabla_id">
                <div class="invalid-feedback" id="error_tabla_id"></div>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Valor</label>
                <input type="text" class="form-control" placeholder="Valor" name="valor" id="valor">
                <div class="invalid-feedback" id="error_valor"></div>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="hidden" name="opcion" value="guardar" id="opcion">
            <input type="hidden" name="id" id="id">
            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="reset" class="btn btn-default float-right" id="btn_cancelar">Cancelar</button>
        </div>

        <?php verCargando(); ?>

    </div>
</form>