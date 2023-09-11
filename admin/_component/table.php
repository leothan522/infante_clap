<div class="table-responsive mt-3">
    <table class="table" id="example1">
        <thead>
        <tr>
            <th style="width: 10px">#</th>
            <th>Task</th>
            <th>Progress</th>
            <th style="width: 40px">Label</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1.</td>
            <td>Update software</td>
            <td>
                <div class="progress progress-xs">
                    <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                </div>
            </td>
            <td><span class="badge bg-danger">55%</span></td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Clean database</td>
            <td>
                <div class="progress progress-xs">
                    <div class="progress-bar bg-warning" style="width: 70%"></div>
                </div>
            </td>
            <td><span class="badge bg-warning">70%</span></td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Cron job running</td>
            <td>
                <div class="progress progress-xs progress-striped active">
                    <div class="progress-bar bg-primary" style="width: 30%"></div>
                </div>
            </td>
            <td><span class="badge bg-primary">30%</span></td>
        </tr>
        <tr>
            <td>4.</td>
            <td>Fix and squish bugs</td>
            <td>
                <div class="progress progress-xs progress-striped active">
                    <div class="progress-bar bg-success" style="width: 90%"></div>
                </div>
            </td>
            <td><span class="badge bg-success">90%</span></td>
        </tr>
        </tbody>
    </table>
</div>

<!-- CSS -->
<!-- DataTables -->
<link rel="stylesheet" href="<?php asset('app/resources/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?php asset('app/resources/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?php asset('app/resources/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">


<!-- JS -->
<!-- DataTables  & Plugins -->
<script src="<?php asset('app/resources/adminlte/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/jszip/jszip.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/pdfmake/pdfmake.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/pdfmake/vfs_fonts.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>
<script src="<?php asset('public/js/datatable-app.js'); ?>"></script>

<!-- SCRIPT -->
<script !src="">
    //Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
    datatable('example1');
</script>

<!--<div class="table-responsive">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Rendering engine</th>
            <th>Browser</th>
            <th>Platform(s)</th>
            <th>Engine version</th>
            <th>CSS grade</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Trident</td>
            <td>Internet
                Explorer 4.0
            </td>
            <td>Win 95+</td>
            <td> 4</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Trident</td>
            <td>Internet
                Explorer 5.0
            </td>
            <td>Win 95+</td>
            <td>5</td>
            <td>C</td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <th>Rendering engine</th>
            <th>Browser</th>
            <th>Platform(s)</th>
            <th>Engine version</th>
            <th>CSS grade</th>
        </tr>
        </tfoot>
    </table>
</div>-->
