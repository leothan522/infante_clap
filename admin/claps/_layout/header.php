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
                <select class="custom-select custom-select-sm rounded-0" id="claps_select_id_municipio">
                    <option value="">MUNICIPIOS</option>
                    <?php
                    foreach ($controller->listarmunicipios() as $listarmunicipio)
                    {
                        if (validarAccesoMunicipio($listarmunicipio['id'])){
                    ?>
                        <option value="<?php echo $listarmunicipio['id']; ?>"> <?php echo $listarmunicipio['nombre'] ?> </option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <form method="POST" action="_export/export_claps.php" id="form_claps_excel">
                    <input type="hidden" placeholder="municipio_id" name="clap_input_municipio_id" id="clap_input_municipio_id">
                </form>
            </ol>
        </div>
    </div>

</div><!-- /.container-fluid -->