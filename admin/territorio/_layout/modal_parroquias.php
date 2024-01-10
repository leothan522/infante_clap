<!-- Modal -->
<div class="modal fade" id="modal-parroquias">
    <div class="modal-dialog">
        <form id="form_parroquias">
            <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="title_parroquia">Parroquia</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ml-2 mr-2">
                <div class="row">
                    <label>Municipio</label>
                    <div class="input-group mb-3">

                        <select class="custom-select rounded-0" name="parroquia_municipio" id="parroquia_municipio">
                            <!--Option con JS-->
                        </select>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-globe"></i>
                            </div>
                        </div>

                        <div class="invalid-feedback" id="error_parroquia_municipio"></div>
                    </div>

                    <label for="name">Nombre Parroquia</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Nombre completo" name="parroquia_nombre" id="parroquia_nombre">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-globe"></i>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="error_parroquia_nombre"></div>
                    </div>

                    <label for="name">Abreviatura</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Ingrese nombre corto" name="parroquia_mini" id="parroquia_mini">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-tag"></i>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="error_parroquia_mini"></div>
                    </div>


                        <label for="name">Asignación</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Ingrese la cantidad de familias" name="parroquia_asignacion" id="parroquia_asignacion">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="error_parroquia_asignacion"></div>
                        </div>




                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="hidden" name="id" id="parroquia_id">
                <input type="hidden" name="opcion" value="guardar_parroquia" id="parroquia_opcion">
                <button type="submit" class="btn btn-primary" id="parroquia_btn_guardar">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="parroquia_btn_cancelar">Cancelar</button>
            </div>
                <?php verCargando(); ?>
        </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->