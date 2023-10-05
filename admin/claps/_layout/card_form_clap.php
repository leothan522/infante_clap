<div class="card card-outline card-indigo">
    <div class="card-header">
        <h3 class="card-title">Datos de CLAPS</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <div class="row">
                <div class="col-md-6">
                    <label>Municipio</label>
                    <div class="input-group mb-3">
                        <select class="custom-select rounded-0 text-uppercase clap_select_municipio" name="clap_select_municipio" onchange="getBloquesParroquias()" id="">
                            <!--Option con JS-->
                        </select>
                        <div class="invalid-feedback error_clap_select_municipio" id=""></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label>Parroquia</label>
                    <div class="input-group mb-3">
                        <select class="custom-select rounded-0 text-uppercase clap_select_parroquia" name="clap_select_parroquia" id="">
                            <option value="">Seleccione</option>

                        </select>
                        <div class="invalid-feedback error_clap_select_parroquia" id=""></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>Bloque</label>
                    <div class="input-group mb-3">
                        <select class="custom-select rounded-0 text-uppercase clap_select_bloque" name="clap_select_bloque" id="">
                            <option value="">Seleccione</option>
                        </select>
                        <div class="invalid-feedback error_clap_select_bloque" id=""></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label>Estracto</label>
                    <div class="input-group mb-3">
                        <select class="custom-select rounded-0 text-uppercase clap_select_estracto" name="clap_select_estracto" id="">
                            <option value="">Seleccione</option>
                            <option value="urbano">Urbano</option>
                            <option value="rural">Rural</option>
                        </select>
                        <div class="invalid-feedback error_clap_select_estracto" id=""></div>
                    </div>
                </div>

            </div>

            <label for="name">Nombre del Clap</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control clap_input_nombre" placeholder="Ingrese el Nombre del Clap" name="clap_input_nombre" id="">
                <div class="invalid-feedback error_clap_input_nombre" id=""></div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="name">Familias</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control clap_input_familias" placeholder="Cantidad" name="clap_input_familias" id="">
                        <div class="invalid-feedback error_clap_input_familias" id=""></div>
                    </div>
                </div>

                <div class="col-md-8">
                    <label>Entes</label>
                    <div class="input-group mb-3">
                        <select class="custom-select rounded-0 text-uppercase clap_select_entes" name="clap_select_entes" id="">
                            <option>Seleccione</option>

                        </select>
                        <div class="invalid-feedback error_clap_select_entes" id=""></div>
                    </div>
                </div>

            </div>

            <label for="name">UBCH <small class="text-muted"> <em>(Opcional)</em></small></label>
            <div class="input-group mb-3">
                <input type="text" class="form-control clap_input_ubch" placeholder="Nombre de la UBCH (Opcional)" name="clap_ubch" id="">
                <div class="invalid-feedback error_clap_input_ubch" id=""></div>
            </div>

        </div>
        <!-- /.card-body -->
    </div>
</div>