<form id="form_create_user">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Crear Usuario</h3>

            <div class="card-tools">
                <!--<button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                    <i class="fas fa-sync-alt"></i>
                </button>-->
                <!--<button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                </button>-->
                <!--<button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>-->
                <button type="button" class="btn btn-tool" data-card-widget="remove" onclick="cerrarDiv()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <label for="name">Nombre</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Nombre completo" name="name" id="name">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_name"></div>
            </div>

            <label for="email">Email</label>
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_email"></div>
            </div>

            <label for="password">Contraseña</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Contraseña" name="password" id="password">
                <div class="input-group-append" style="cursor: pointer;" onclick="generarClave()">
                    <div class="input-group-text">
                        <i class="fas fa-key"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_password"></div>
            </div>

            <label for="telefono">Teléfono</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Número de teléfono" name="telefono" id="telefono">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_telefono"></div>
            </div>

            <label for="telefono">Tipo</label>
            <div class="input-group mb-3">
                <?php $controller->getRoles(); ?>
                <select class="custom-select rounded-0 select_roles_usuarios" name="tipo" id="tipo">
                    <option value="">Seleccione</option>
                    <option value="0">Público</option>
                    <option value="1">Estandar</option>
                    <?php foreach ($controller->roles as $role) { ?>
                        <option value="<?php echo $role['id'] ?>"><?php echo ucfirst($role['nombre']); ?></option>
                    <?php } ?>
                    <option value="99">Administrador</option>
                </select>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>

                <div class="invalid-feedback" id="error_tipo"></div>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="hidden" name="opcion" value="store" id="opcion">
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
            <button type="reset" class="btn btn-default float-right" onclick="resetForm()" id="btn_reset_create_user">Cancelar</button>
        </div>

        <?php verCargando(); ?>

    </div>
</form>