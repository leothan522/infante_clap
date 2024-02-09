<div class="card card-outline card-primary" id="claps_listar_card">
    <div class="card-header">
        <h3 class="card-title">Claps Registrados</h3>

        <div class="card-tools">

            <button type="submit" class="btn btn-tool text-success swalDefaultInfo"
                    onclick="clickDescargarClaps()" id="clap_table_export_excel"
                    <?php if (!validarPermisos()){ ?> disabled <?php } ?>>
                <i class="fas fa-file-excel"></i> <i class="fas fa-download"></i>
            </button>
            <button class="btn btn-tool" data-toggle="modal"
                    onclick="resetClap('clap_create_select_municipio', 'clap_create_select_entes')"
                    data-target="#modal-claps" disabled >
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body" >
        Seleccione un <strong>Municipio</strong> para empezar...
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix" id="claps_listar_footer">
        <?php /*echo $links; */?>
    </div>
    <?php verCargando(); ?>
</div>