<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            Bloques Registrados
        </h3>

        <div class="card-tools">
            <!--<button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>-->
            <select class="custom-select custom-select-sm rounded-0" onchange="cambiarMunicipio()" id="bloques_select_municipios"></select>
            <div class="invalid-feedback" id="error_bloques_municipio"></div>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body" id="dataContainerBloques">
        <span>Seleccione un Municipio para empezar</span>
    </div>
    <!-- /.card-body -->
    <!--<div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </div>-->

</div>