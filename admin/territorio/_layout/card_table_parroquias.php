<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Parroquias</h3>

        <div class="card-tools">
            <button class="btn btn-tool" data-toggle="modal" data-target="#modal-parroquias">
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <div class="table-responsive mt-3">
            <table class="table" id="example1">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nombre</th>
                    <th>Municipio</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1.</td>
                    <td>San Juan</td>
                    <td>Roscio</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-parroquias">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-info">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </div>
</div>