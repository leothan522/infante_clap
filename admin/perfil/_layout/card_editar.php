<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Editar Perfil</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
        <div id="accordion">
            <div class="card card-indigo">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                            Información Personal
                            <span class="float-right">
                                <i class="fas fa-user-edit"></i>
                            </span>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <?php require_once "form_datos_personales.php"; ?>
                    </div>
                </div>
            </div>
            <div class="card card-lightblue">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                            Seguridad
                            <span class="float-right">
                                <i class="fas fa-user-shield"></i>
                            </span>
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <?php require_once "form_seguridad.php"; ?>
                    </div>
                </div>
            </div>
            <!--<div class="card card-navy">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                            Imagen de Perfil
                            <span class="float-right">
                                <i class="fas fa-user-circle"></i>
                            </span>
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <?php /*require_once "form_imagen_perfil.php"; */?>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
    <!-- /.card-body -->
    <?php verCargando(); ?>
</div>
<!-- /.card -->