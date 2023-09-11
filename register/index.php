<?php
session_start();
require_once "../vendor/autoload.php";

use app\controller\GuestController;

$controller = new GuestController();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php asset('app/favicon/apple-icon-57x57.png') ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php asset('app\\favicon\\apple-icon-60x60.png') ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php asset('app\\favicon\\apple-icon-72x72.png') ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php asset('app\\favicon\\apple-icon-76x76.png') ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php asset('app\\favicon\\apple-icon-114x114.png') ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php asset('app\\favicon\\apple-icon-120x120.png') ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php asset('app\\favicon\\apple-icon-144x144.png') ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php asset('app\\favicon\\apple-icon-152x152.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php asset('app\\favicon\\apple-icon-180x180.png') ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php asset('app\\favicon\\android-icon-192x192.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php asset('app\\favicon\\android-icon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php asset('app\\favicon\\android-icon-96x96.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php asset('app\\favicon\\favicon-16x16.png') ?>">
    <link rel="manifest" href="<?php asset('app\\favicon\\manifest.json') ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php asset('app\\favicon\\ms-icon-144x144.png') ?>">
    <meta name="theme-color" content="#ffffff">

    <title>Alguarisa CLAPS | Registro</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php asset('app/resources/adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet"
          href="<?php asset('app/resources/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet"
          href="<?php asset('app/resources/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php asset('app/resources/adminlte/dist/css/adminlte.min.css'); ?>">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="./" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Registrarse</p>

            <form class="mb-3" id="form_registrar_usuario">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nombre completo" name="name" id="name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_name"></div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_email"></div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Contraseña" name="password" id="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_password"></div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Vuelva a escribir la contraseña"
                           name="confirmar" id="confirmar">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_confirmar"></div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Número de teléfono" name="telefono"
                           id="telefono">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_telefono"></div>
                </div>
                <div class="row">
                    <div class="col-7">
                        <!--<div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                Acepto los <a href="#">términos</a>
                            </label>
                        </div>-->
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember" class="text-xs">
                                Mostrar Contraseñas
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-5">
                        <input type="hidden" name="opcion" value="guardar">
                        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="../login" class="text-center">Ya estoy registrado</a>
        </div>
        <!-- /.form-box -->

        <?php verCargando(); ?>

    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="<?php asset('app/resources/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php asset('app/resources/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php asset('app/resources/adminlte/dist/js/adminlte.min.js'); ?>"></script>
<!-- SweetAlert2 -->
<script src="<?php asset('app/resources/adminlte/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
<script src="<?php asset('public/js/sweetalert-app.js'); ?>"></script>
<!-- InputMask -->
<script src="<?php asset('app/resources/adminlte/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/inputmask/jquery.inputmask.min.js'); ?>"></script>


<script src="_app/register.js"></script>
</body>
</html>
