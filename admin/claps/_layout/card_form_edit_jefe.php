<div class="card card-outline card-indigo">
    <div class="card-header">
        <h3 class="card-title">Jefe de Comunidad</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <label for="name">Cédula</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control jefe_input_cedula" placeholder="Ingrese la Cédula" name="jefe_input_edit_cedula" id="">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>
                <div class="invalid-feedback error_jefe_input_cedula" id=""></div>
            </div>

            <label for="name">Nombre del Jefe</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control jefe_input_nombre" placeholder="Ingrese el Nombre completo" name="jefe_input_edit_nombre" id="">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="invalid-feedback error_jefe_input_nombre" id=""></div>
            </div>

            <label>Género</label>
            <div class="input-group mb-3">
                <select class="custom-select rounded-0 text-uppercase jefe_select_genero" name="jefe_select_edit_genero" id="">
                    <option value="">Seleccione</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                </select>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-restroom"></i>
                    </div>
                </div>
                <div class="invalid-feedback error_jefe_select_genero" id=""></div>
            </div>

            <label for="name">Teléfono</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control jefe_input_telefono" placeholder="Ingrese el Teléfono" name="jefe_input_edit_telefono" id="">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                </div>
                <div class="invalid-feedback error_jefe_input_telefono" id=""></div>
            </div>

            <label for="name">Correo <small class="text-muted"><em>(Opcional)</em></small></label>
            <div class="input-group mb-3">
                <input type="email" class="form-control jefe_input_edit_email" placeholder="Ingrese el correo electrónico (Opcional)" name="jefe_input_edit_email" id="">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-at"></i>
                    </div>
                </div>
                <div class="invalid-feedback error_jefe_input_edit_email" id=""></div>
            </div>

        </div>
        <!-- /.card-body -->
    </div>
</div>