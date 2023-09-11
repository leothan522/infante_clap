<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                 src="<?php asset('public/img/user_blank.png'); ?>"
                 alt="User profile picture" id="profile_imagen">
        </div>

        <h3 class="profile-username text-center" id="profile_name"><?php echo $controller->USER_NAME?></h3>

        <p class="text-muted text-center" id="profile_tipo"><?php echo verRoleUsuario($controller->USER_ROLE) ?></p>

        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>Email</b> <a class="float-right" id="profile_email"><?php echo $controller->USER_EMAIL ?></a>
            </li>
            <li class="list-group-item">
                <b>Teléfono</b> <a class="float-right" id="profile_telefono"><?php echo $controller->USER_TELEFONO ?></a>
            </li>
            <li class="list-group-item">
                <b>Estatus</b> <a class="float-right" id="profile_estatus"><span class="text-success"><?php echo verEstatusUsuario($controller->USER_STATUS, false) ?></span></a>
            </li>
            <li class="list-group-item">
                <b>Fecha Registro</b> <a class="float-right" id="profile_fecha"><?php echo verFecha($controller->USER_CREATED_AT)?></a>
            </li>
        </ul>

    </div>
    <!-- /.card-body -->
    <?php verCargando(); ?>
</div>