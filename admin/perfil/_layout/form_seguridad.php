<form id="form_perfil_seguridad">


    <label for="edit_name">Contraseña Actual</label>
    <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Ingrese su contraseña actual" name="contrasea_actual" id="contrasea_actual">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        <div class="invalid-feedback" id="error_contrasea_actual"></div>
    </div>

    <label for="edit_name">Contraseña Nueva</label>
    <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Ingrese su nueva contraseña" name="contrasea_nueva" id="contrasea_nueva">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        <div class="invalid-feedback" id="error_contrasea_nueva"></div>
    </div>

    <label for="edit_name">Confirmar</label>
    <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Confirme la contraseña" name="confirmar" id="confirmar">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        <div class="invalid-feedback" id="error_confirmar"></div>
    </div>

    <div class="col-6 input-group mb-3">
        <div class="icheck-primary">
            <input type="checkbox" id="remember">
            <label for="remember" class="text-sm">
                Mostrar Contraseñas
            </label>
        </div>
    </div>



        <input type="hidden" name="opcion" value="editar_seguridad" id="edit_opcion">
        <button type="submit" class="btn bg-lightblue btn-block">Guardar Cambios</button>
        <!--<button type="reset" class="btn btn-default float-right">Restablecer</button>-->


</form>