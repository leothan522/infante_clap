<form id="bancos_form">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title" id="title_form_cuotas">Crear Bancos</h3>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputPassword1">Nombre</label>
                <input type="text" class="form-control" placeholder="Nombre del Banco" name="bancos_form_nombre" id="bancos_form_nombre">
                </select>
                <div class="invalid-feedback" id="error_bancos_nombre"></div>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Código</label>
                <input type="text" class="form-control" placeholder="Código del Banco" name="bancos_form_codigo" id="bancos_form_codigo">
                <div class="invalid-feedback" id="error_bancos_codigo"></div>
            </div>

        </div>


        <!-- /.card-body -->

        <div class="card-footer">
            <input type="hidden" placeholder="id" name="bancos_id" id="bancos_id">
            <input type="hidden" name="opcion" value="store" id="bancos_opcion">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>

    </div>
</form>
