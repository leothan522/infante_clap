<div class="card card-outline card-indigo">
    <div class="card-header">
        <h3 class="card-title">Jefe de Comunidad</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal"
                    data-target="#editar-jefe" onclick="editJefe(0)"
                <?php if (!validarPermisos("jefes.edit")){ echo 'disabled'; } ?>  >
                <i class="fas fa-user-edit"></i> Editar
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <label for="name">Cédula:</label>
            <div class="input-group mb-3">

                <span class="text-muted" id="show_jefe_cedula">27613025</span>

            </div>

            <label for="name">Nombre del Jefe:</label>
            <div class="input-group mb-3">

                <span class="text-muted text-uppercase" id="show_jefe_nombre">Antonny Maluenga</span>

            </div>

            <label>Género:</label>
            <div class="input-group mb-3">

                <span class="text-muted text-uppercase" id="show_jefe_genero">Masculino</span>

            </div>

            <label for="name">Teléfono:</label>
            <div class="input-group mb-3">

                <span class="text-muted" id="show_jefe_telefono">0412-199.56.47</span>

            </div>

            <label for="name">Correo:</label>
            <div class="input-group mb-3">

                <span class="text-muted text-uppercase" id="show_jefe_correo">gabrielmalu15@gmail.com</span>

            </div>

        </div>
        <!-- /.card-body -->
    </div>
</div>