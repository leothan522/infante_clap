<div class="card card-outline card-indigo">
    <div class="card-header">
        <h3 class="card-title">Jefe de Comunidad</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <label for="name">Cédula</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Ingrese la Cédula" name="jefe_input_cedula" id="jefe_create_input_cedula">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_jefe_create_input_cedula"></div>
            </div>

            <label for="name">Nombre del Jefe</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Ingrese el Nombre completo" name="jefe_input_nombre" id="jefe_create_input_nombre">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_jefe_-input_nombre"></div>
            </div>

            <label>Género</label>
            <div class="input-group mb-3">
                <select class="custom-select rounded-0 text-uppercase" name="jefe_select_genero" id="jefe_create_select_genero">
                    <option value="">Seleccione</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                </select>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-restroom"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_jefe_create_select_genero"></div>
            </div>

            <label for="name">Teléfono</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Ingrese el Teléfono" name="jefe_input_telefono" id="jefe_create_input_telefono">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_jefe_create_input_telefono"></div>
            </div>

            <label for="name">Correo <small class="text-muted"><em>(Opcional)</em></small></label>
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Ingrese el correo electrónico (Opcional)" name="jefe_input_email" id="jefe_create_input_email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-at"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_jefe_create_input_email"></div>
            </div>

        </div>
        <!-- /.card-body -->
    </div>
</div>