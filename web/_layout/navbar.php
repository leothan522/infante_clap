<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="./" class="navbar-brand">
            <img src="<?php asset('app/resources/adminlte/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light"><?php echo mb_strtoupper(config('app_name')) ?></span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button class="btn nav-link" onclick="irDashboard()">Dashboard</button>
                </li>
            </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item user-menu">
              <span class="nav-link">
                  <img src="<?php asset('app/resources/adminlte/dist/img/user2-160x160.jpg'); ?>" class="user-image img-circle elevation-2" alt="User Image">
                  <span class="d-none d-md-inline">
                    <?php echo $controller->USER_NAME; ?>
                </span>
              </span>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <!--<li class="user-header bg-primary">
                      <img src="<?php /*asset('app/resources/adminlte/dist/img/user2-160x160.jpg'); */?>" class="img-circle elevation-2" alt="User Image">

                      <p>
                          <?php /*echo $controller->USER_NAME; */?>
                          <small><?php /*echo $controller->USER_EMAIL; */?></small>
                      </p>
                  </li>-->
                    <!-- Menu Footer-->
                    <!--<li class="user-footer">
                        <a href="../logout" class="btn btn-default btn-flat float-right">Cerrar sesión</a>
                    </li>-->
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php asset('logout'); ?>" role="button">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>
