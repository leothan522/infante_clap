<form id="form_perfil_datos">


    <label for="edit_name">Contraseña Actual</label>
    <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Ingrese su contraseña actual" name="password" id="password_actual_datos">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        <div class="invalid-feedback" id="error_password_actual"></div>
    </div>



    <label for="edit_name">Nombre</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Nombre completo" value="<?php echo $controller->USER_NAME ?>" name="name" id="edit_name">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
        <div class="invalid-feedback" id="error_edit_name"></div>
    </div>

    <label for="edit_email">Email</label>
    <div class="input-group mb-3">
        <input type="email" class="form-control" placeholder="Email" value="<?php echo $controller->USER_EMAIL ?>" name="email" id="edit_email">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
        <div class="invalid-feedback" id="error_edit_email"></div>
    </div>

    <label for="edit_telefono">Teléfono</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Número de teléfono" value="<?php echo $controller->USER_TELEFONO ?>" name="telefono" id="edit_telefono">
        <div class="input-group-append">
            <div class="input-group-text">
                <i class="fas fa-mobile-alt"></i>
            </div>
        </div>
        <div class="invalid-feedback" id="error_edit_telefono"></div>
    </div>


    <div class="col-6 input-group mb-3">
        <div class="icheck-primary">
            <input type="checkbox" id="check_datos">
            <label for="remember" class="text-sm">
                Mostrar Contraseña
            </label>
        </div>
    </div>
    <input type="hidden" name="opcion" value="editar_datos" id="edit_opcion">
    <button type="submit" class="btn bg-indigo">Guardar Cambios</button>
    <button type="reset" class="btn btn-default float-right">Restablecer</button>


</form>