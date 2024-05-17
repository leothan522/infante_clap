<div class="card card-primary card-outline">
    <div class="card-body box-profile">

            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle ima_profile_user"
                     src="<?php echo verImagen($controller->USER_PATH, true); ?>"
                     alt="User profile picture" id="profile_imagen">
            </div>


        <form id="form_profile_imagen" method="post"  enctype="multipart/form-data">
            <div class="text-center mt-2" id="btn_subir">
                <label class="btn btn-primary btn-sm">
                    Subir Foto <i class="fas fa-edit"></i>
                    <input type="file" name="seleccionar_imagen" id="seleccionar_imagen" hidden accept="image/*">
                </label>
            </div>
            <input type="hidden" value="store_imagen" name="opcion" id="opcion">
            <div class="text-center d-none" id="btn_guardar_cancelar">
                <button type="submit" class="btn btn-success  btn-sm" name="guardar_imagen" id="guardar_imagen">
                    <i class="fas fa-save"></i> Guardar
                </button>

                <a class="btn btn-danger  btn-sm">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>


        <h3 class="profile-username text-center" id="profile_name"><?php echo $controller->USER_NAME?></h3>

        <p class="text-muted text-center" id="profile_tipo"><?php echo $controller->getRol($controller->USER_ROLE, $controller->USER_ROLE_ID) ?></p>

        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>Email</b> <a class="float-right" id="profile_email"><?php echo $controller->USER_EMAIL ?></a>
            </li>
            <li class="list-group-item">
                <b>Teléfono</b> <a class="float-right" id="profile_telefono"><?php echo $controller->USER_TELEFONO ?></a>
            </li>
            <li class="list-group-item">
                <b>Estatus</b> <a class="float-right" id="profile_estatus"><span class="text-success"><?php echo $controller->verEstatusUsuario($controller->USER_STATUS, false) ?></span></a>
            </li>
            <li class="list-group-item">
                <b>Fecha Registro</b> <a class="float-right" id="profile_fecha"><?php echo verFecha($controller->USER_CREATED_AT)?></a>
            </li>
            <li class="list-group-item">
                <b>GET</b>
                <a class="float-right" id="profile_fecha">
                    <?php echo verImagen('public/img/profile/batman-2560x14401.jpg', true) ?>
                </a>
            </li>

        </ul>

    </div>
    <!-- /.card-body -->
    <?php verCargando(); ?>
</div>