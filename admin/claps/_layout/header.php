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
                    { ?>
                        <option value="<?php echo $listarmunicipio['id']; ?>"> <?php echo $listarmunicipio['nombre'] ?> </option>
                    <?php } ?>
                </select>
            </ol>
        </div>
    </div>

</div><!-- /.container-fluid -->