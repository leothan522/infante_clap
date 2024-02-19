<div class="card card-outline card-primary">

    <div class="card-header">
        <h3 class="card-title">
            <?php if (!isset($keyword)){ ?>
            Claps Registrados
            <?php }else { ?>
                Resultados para la busqueda [<strong class="text-danger"><?php echo mb_strtoupper($keyword); ?></strong>]
                <?php if ($controller->id){ ?>
                    del municipio [<strong class="text-danger"><?php echo mb_strtoupper($municipio['mini']); ?></strong>]
                <?php } ?>
            <?php } ?>
        </h3>

        <div class="card-tools">

            <button type="submit" class="btn btn-tool text-success swalDefaultInfo"
                    onclick="clickDescargarClaps()" id="clap_table_export_excel"
                <?php if (empty($id)) { ?> disabled <?php } ?>>
                <i class="fas fa-file-excel"></i> <i class="fas fa-download"></i>
            </button>
            <button class="btn btn-tool" data-toggle="modal"
                    onclick="resetClap('clap_create_select_municipio', 'clap_create_select_entes')"
                    data-target="#modal-claps" <?php if (!validarPermisos('claps.create') || empty($id)){ ?> disabled <?php } ?>>
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">


        <div class="row">
            <div class="col-12">
            <?php
                if (empty($controller->listarClap) && is_null($controller->id)){
            ?>
            Seleccione un <strong>Municipio</strong> para empezar...
            <?php
                }else {
                    require '_layout/table_claps.php';
                }
             ?>
            </div>
        </div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <?php echo $controller->links;  ?>
    </div>
    <?php verCargando(); ?>

</div>

