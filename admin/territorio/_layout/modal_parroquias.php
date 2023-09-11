<!-- Modal -->
<div class="modal fade" id="modal-parroquias">
    <div class="modal-dialog">
        <form action="#">
            <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Parroquia</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label>Municipio</label>
                    <div class="input-group mb-3">

                        <select class="custom-select rounded-0">
                            <option value="">Seleccione</option>
                            <option value="">Infante</option>
                        </select>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        </div>

                        <div class="invalid-feedback" id="error_tipo"></div>
                    </div>

                    <label for="name">Nombre Parroquia</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Nombre completo" name="name" id="name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="error_name"></div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="hidden" name="id" id="">
                <input type="hidden" name="opcion" value="guardar" id="">
                <button type="submit" class="btn btn-primary" id="">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->