<!-- Modal -->
<div class="modal fade" id="modal-claps">
    <div class="modal-dialog modal-lg">
        <form id="form_create_clap">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="clap_title">Gestionar CLAPS</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-outline card-indigo">
                                <div class="card-header">
                                    <h3 class="card-title">Datos del CLAPS</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Municipio</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select rounded-0" name="clap_select_municipio"
                                                            id="clap_select_municipio">
                                                        <option>Seleccione...</option>
                                                        <option value="1">Infante</option>
                                                    </select>
                                                    <div class="invalid-feedback" id="error_clap_select_municipio"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Parroquia</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select rounded-0" name="clap_select_parroquia"
                                                            id="clap_select_parroquia">
                                                        <option>Seleccione...</option>
                                                        <option value="1">Infante</option>
                                                    </select>
                                                    <div class="invalid-feedback" id="error_clap_select_parroquia"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Bloque</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select rounded-0" name="clap_select_bloque"
                                                            id="clap_select_bloque">
                                                        <option>Seleccione...</option>
                                                        <option value="1">Bloque 1</option>
                                                    </select>
                                                    <div class="invalid-feedback" id="error_clap_select_bloque"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Estracto</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select rounded-0" name="clap_select_estracto"
                                                            id="clap_select_estracto">
                                                        <option>Seleccione...</option>
                                                        <option value="1">Urbano</option>
                                                        <option value="Mixto">Rural</option>
                                                    </select>
                                                    <div class="invalid-feedback" id="error_clap_select_entes"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <label for="name">Nombre</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese el Nombre del Clap" name="clap_nombre" id="clap_nombre">
                                            <div class="invalid-feedback" id="error_clap_nombre"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="name">Familias</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Cantidad" name="clap_familias" id="clap_familias">
                                                    <div class="invalid-feedback" id="error_clap_familias"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <label>Entes</label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select rounded-0" name="clap_select_entes"
                                                            id="clap_select_entes">
                                                        <option>Seleccione...</option>
                                                        <option value="1">Alimentos del guarico.s.a</option>
                                                        <option value="Mixto">Mixto</option>
                                                    </select>
                                                    <div class="invalid-feedback" id="error_clap_select_entes"></div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-outline card-indigo">
                                <div class="card-header">
                                    <h3 class="card-title">Jefe de Comunidad</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div>
                                        <label for="name">Cédula</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese la Cédula"
                                                   name="jefe_cedula" id="jefe_cedula">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fas fa-id-card"></i>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback" id="error_jefe_cedula"></div>
                                        </div>

                                        <label for="name">Nombre</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control"
                                                   placeholder="Ingrese el Nombre completo" name="jefe_nombre"
                                                   id="jefe_nombre">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback" id="error_jefe_nombre"></div>
                                        </div>

                                        <label>Género</label>
                                        <div class="input-group mb-3">
                                            <select class="custom-select rounded-0" name="jefe_select_genero"
                                                    id="jefe_select_genero">
                                                <option>Seleccione..</option>
                                                <option value="1">Clap 1</option>
                                            </select>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fas fa-restroom"></i>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback" id="error_jefe_select_genero"></div>
                                        </div>

                                        <label for="name">Teléfono</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese el Teléfono"
                                                   name="jefe_telefono" id="jefe_telefono">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fas fa-mobile-alt"></i>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback" id="error_jefe_nombre"></div>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
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