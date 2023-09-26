<!-- Modal -->
<div class="modal fade" id="modal-claps">
    <div class="modal-dialog">
        <form id="form_claps">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="clap_title">Gestionar CLAPS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="name">Nombre del CLAP</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Ingrese el nombre del CLAP" name="clap_nombre" id="clap_nombre">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-id-card"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="error_clap_nombre"></div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="name">Estracto</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Ingrese el estracto" name="clap_estracto" id="clap_estracto">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-city"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="error_clap_estracto"></div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="name">Familias</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Ingrese la cantidad de familias" name="clap_familia" id="clap_familias">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="error_clap_familias"></div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="name">Municipios</label>
                        <div class="input-group mb-3">
                            <select class="custom-select" name="clap_select_municipios" id="clap_select_municipios">
                                <option value="">Seleccione...</option>
                                <option value="1">Infante</option>
                                <option value="2">Camaguan</option>
                                <option value="3">Guayabal</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="error_clap_municipio"></div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="name">Parroquias</label>
                        <div class="input-group mb-3">
                            <select class="custom-select" name="clap_select_municipios" id="clap_select_municipios">
                                <option value="">Seleccione...</option>
                                <option value="1">Infante</option>
                                <option value="2">Camaguan</option>
                                <option value="3">Guayabal</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="error_clap_parroquia"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="id" placeholder="clap_id" id="clap_id">
                    <input type="hidden" name="opcion" value="guardar_clap" id="clap_opcion">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
                <?php verCargando(); ?>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->