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
                        <select class="custom-select rounded-0 text-uppercase select2" name="clap_select_municipio"
                                onchange="getBloquesParroquias('#clap_create_select_municipio', '#clap_create_select_bloque', '#clap_create_select_parroquia')"
                                id="clap_create_select_municipio">
                            <!--Option con JS-->
                        </select>
                        <div class="invalid-feedback" id="error_clap_create_select_municipio"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label>Parroquia</label>
                    <div class="input-group mb-3">
                        <select class="custom-select rounded-0 text-uppercase select2" name="clap_select_parroquia" id="clap_create_select_parroquia">
                            <option value="">Seleccione</option>

                        </select>
                        <div class="invalid-feedback" id="error_clap_create_select_parroquia"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>Bloque</label>
                    <div class="input-group mb-3">
                        <select class="custom-select rounded-0 text-uppercase" name="clap_select_bloque" id="clap_create_select_bloque">
                            <option value="">Seleccione</option>
                        </select>
                        <div class="invalid-feedback" id="error_clap_create_select_bloque"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label>Estracto</label>
                    <div class="input-group mb-3">
                        <select class="custom-select rounded-0 text-uppercase" name="clap_select_estracto" id="clap_create_select_estracto">
                            <option value="">Seleccione</option>
                            <option value="urbano">Urbano</option>
                            <option value="rural">Rural</option>
                        </select>
                        <div class="invalid-feedback" id="error_clap_create_select_estracto"></div>
                    </div>
                </div>

            </div>

            <label for="name">Nombre del Clap</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Ingrese el Nombre del Clap" name="clap_input_nombre" id="clap_create_input_nombre">
                <div class="invalid-feedback" id="error_clap_create_input_nombre"></div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="name">Familias</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cantidad" name="clap_input_familias" id="clap_create_input_familias">
                        <div class="invalid-feedback" id="error_clap_create_input_familias"></div>
                    </div>
                </div>

                <div class="col-md-8">
                    <label>Entes</label>
                    <div class="input-group mb-3">
                        <select class="custom-select rounded-0 text-uppercass" name="clap_select_entes" id="clap_create_select_entes">
                            <option>Seleccione</option>

                        </select>
                        <div class="invalid-feedback" id="error_clap_create_select_entes"></div>
                    </div>
                </div>

            </div>

            <label for="name">UBCH <small class="text-muted"> <em>(Opcional)</em></small></label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Nombre de la UBCH (Opcional)" name="clap_ubch" id="clap_create_input_ubch">
                <div class="invalid-feedback" id="error_clap_create_input_ubch"></div>
            </div>

        </div>
        <!-- /.card-body -->
    </div>
</div>