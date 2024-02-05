<div class="card card-outline card-indigo">
    <div class="card-header">
        <h3 class="card-title">Datos de CLAPS</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal"
                    data-target="#editar-clap" onclick="editClap(0)"
                    <?php if (!validarPermisos("claps.edit")){ echo 'disabled'; } ?>   >
                <i class="far fa-edit"></i> Editar
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <div class="row">
                <div class="col-md-6">
                    <label>Municipio:</label>
                    <div class="input-group mb-3">

                        <span class="text-muted text-uppercase" id="show_clap_municipio">ROSCIO</span>

                    </div>
                </div>

                <div class="col-md-6">
                    <label>Parroquia:</label>
                    <div class="input-group mb-3">

                        <span class="text-muted text-uppercase" id="show_clap_parroquia">SAN JUAN</span>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>Bloque:</label>
                    <div class="input-group mb-3">

                        <span class="text-muted" id="show_clap_bloque">1</span>

                    </div>
                </div>

                <div class="col-md-6">
                    <label>Estracto:</label>
                    <div class="input-group mb-3">

                        <span class="text-muted text-uppercase" id="show_clap_estracto">RURAL</span>

                    </div>
                </div>

            </div>

            <label for="name">Nombre del Clap:</label>
            <div class="input-group mb-3">

                <span class="text-muted text-uppercase" id="show_clap_nombre">PUEBLO NUEVO</span>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="name">Familias:</label>
                    <div class="input-group mb-3">

                        <span class="text-muted" id="show_clap_familias">765</span>

                    </div>
                </div>

                <div class="col-md-6">
                    <label>Entes:</label>
                    <div class="input-group mb-3">

                        <span class="text-muted text-uppercase" id="show_clap_entes">ALGUARISA</span>

                    </div>
                </div>

            </div>

            <label for="name">UBCH:</label>
            <div class="input-group mb-3">
                <span class="text-muted text-uppercase" id="show_clap_ubch">SAN JUAN</span>
            </div>

        </div>
        <!-- /.card-body -->
    </div>
</div>