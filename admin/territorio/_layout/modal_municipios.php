<!-- Modal -->
<div class="modal fade" id="modal-municipios">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_territorio_municipio">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="municipio_title">Municipio</h4>
                    <button type="button" class="close" onclick="resetMunicipio()" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ml-2 mr-2">
                    <div class="row">
                        <label for="name">Nombre Municipio</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nombre completo" name="mun_municipio"
                                   id="municipio_nombre">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-globe"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="error_municipio_nombre"></div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="name">Abreviatura</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Ingrese nombre corto"
                                   name="municipio_mini" id="municipio_mini">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-tag"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="error_municipio_mini"></div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="name">Asignación</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Ingrese la cantidad de familias"
                                   name="municipio_asignacion" id="municipio_asignacion">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="error_municipio_asignacion"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="id" placeholder="municipio_id" id="municipio_id">
                    <input type="hidden" name="opcion" value="store" id="municipio_opcion">
                    <button type="submit" class="btn btn-primary" id="municipio_btn_button">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="resetMunicipio()"
                            id="municipio_btn_reset">Cancelar
                    </button>
                </div>
                <?php verCargando(); ?>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->