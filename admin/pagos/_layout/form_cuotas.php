<form id="cuotas_form">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title" id="title_form_cuotas">Crear Cuota</h3>

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
                <label for="exampleInputPassword1">Mes</label>
                <select class="custom-select rounded-0 text-uppercase" name="cuotas_select_mes" id="cuotas_select_mes">
                    <option value="">Seleccione</option>
                    <?php
                    $meses = mesEspanol();
                    foreach ($meses as $numMes => $mes) {
                        echo "<option value='" . ($numMes + 1) . "'>" . $mes . "</option>";
                    }
                    ?>
                </select>
                <div class="invalid-feedback" id="error_cuotas_select_mes"></div>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Fecha de Inicio</label>
                <input type="date" class="form-control" name="cuotas_input_fecha" id="cuotas_input_fecha">
                <div class="invalid-feedback" id="error_cuotas_input_fecha"></div>
            </div>


            <div class="form-group">
                <label>Precio</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Precio del Modulo" name="cuotas_input_precio" id="cuotas_input_precio">
                    <div class="input-group-append">
                        <div class="input-group-text text-bold">
                            Bs.
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_cuotas_input_precio"></div>
                </div>
            </div>

            <div class="form-group">
                <label>Adicional <small class="text-muted"> <em>(Opcional)</em></small> </label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Costos Adicionales" name="cuotas_input_adicional" id="cuotas_input_adicional">
                    <div class="input-group-append">
                        <div class="input-group-text text-bold">
                            Bs.
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_cuotas_input_adicional"></div>
                </div>
            </div>

            <div class="form-group">
                <input type="text" placeholder="municipios_id" name="municipios_id" id="input_hidde_municipios_id">
            </div>
            
        </div>


        <!-- /.card-body -->

        <div class="card-footer">
            <input type="hidden" placeholder="id" name="cuotas_id" id="cuotas_id">
            <input type="hidden" name="opcion" value="guardar_cuotas" id="cuotas_opcion">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>

    </div>
</form>