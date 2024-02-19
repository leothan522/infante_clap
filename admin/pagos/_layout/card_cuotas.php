<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Cuotas Registradas</h3>
        <div class="card-tools">
            <select class="custom-select custom-select-sm rounded-0" onchange="cambiarMunicipio()"
                    id="cuotas_select_municipios"></select>
            <div class="invalid-feedback" id="error_cuotas_municipio"></div>
        </div>
    </div>

    <div class="row" id="card_body_cuotas">
        <!-- HTML por JV -->
    </div>
    <?php verCargando(); ?>
</div>