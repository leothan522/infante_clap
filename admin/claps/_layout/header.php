<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1> <i class="fas fa-users"></i> Gestionar CLAPS</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <!--<li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Layout</a></li>
                <li class="breadcrumb-item active">Fixed Navbar Layout</li>-->
                <?php require '../_layout/mount_select_municipio.php'; ?>
                <form method="POST" action="_export/export_claps.php" id="form_claps_excel">
                    <input type="hidden" placeholder="municipio_id" name="clap_input_municipio_id" id="clap_input_municipio_id">
                </form>
            </ol>
        </div>
    </div>

</div><!-- /.container-fluid -->