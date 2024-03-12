<!-- Modal -->
<div class="modal fade" id="modal-acceso_municipio">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Acceso a Municipios</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">
                        <?php require_once 'card_form_acceso.php'; ?>
                    </div>

                    <div class="col-md-8" id="usuario_card_table">

                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Accesos Registrados </h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="height: 150px">
                                <!--JS-->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                            </div>
                            <div class="overlay-wrapper">
                                <div class="overlay">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            <?php verCargando(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
