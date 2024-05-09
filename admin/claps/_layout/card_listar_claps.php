<div class="card card-outline card-primary">

    <div class="card-header">
        <h3 class="card-title">
            <?php if (!isset($controller->keyword)){ ?>
            Claps Registrados
            <?php }else { ?>
                Resultados para la busqueda [<strong class="text-danger"><?php echo mb_strtoupper($controller->keyword); ?></strong>]
                <?php
                if ($controller->idMunicipio){
                    $municipio = $controller->getMunicipio($controller->idMunicipio);
                ?>
                    del municipio [<strong class="text-danger"><?php echo mb_strtoupper($municipio['mini']); ?></strong>]
                <?php } ?>
                <button type="button" class="btn btn-tool" onclick="reconstruirTabla()">
                    <i class="fas fa-times-circle"></i>
                </button>
            <?php } ?>
        </h3>

        <div class="card-tools">

            <button type="submit" class="btn btn-tool text-success swalDefaultInfo"
                    onclick="clickDescargarClaps()" id="clap_table_export_excel"
                <?php if (empty($controller->idMunicipio) && !validarPermisos()) { ?> disabled <?php } ?>>
                <i class="fas fa-file-excel"></i> <i class="fas fa-download"></i>
            </button>
            <button class="btn btn-tool" data-toggle="modal"
                    onclick="resetClap('clap_create_select_municipio', 'clap_create_select_entes')"
                    data-target="#modal-claps" <?php if (!validarPermisos('claps.create') || empty($controller->idMunicipio)){ ?> disabled <?php } ?>>
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">


        <div class="row">
            <div class="col-12">
            <?php if (!isset($buscar) && empty($controller->rows) && is_null($controller->idMunicipio)){ ?>
            Seleccione un <strong>Municipio</strong> para empezar...
            <?php }else {
                require '../_layout/table_claps.php';
            }
             ?>
            </div>
        </div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <?php
        if (empty($controller->keyword)){
            echo $controller->links;
        }else{
            if (isset($i)){
                echo "Mostrando ".$i;
            }
        }
        ?>
    </div>
    <?php verCargando(); ?>

</div>

