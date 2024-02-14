<?php
/*
session_start();
# Declaramos la librería
require '../../../vendor/autoload.php';

use app\controller\ClapsController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use app\model\Clap;
use app\model\Jefe;
use app\model\Municipio;
use app\model\Parroquia;
use app\model\Bloque;
use app\model\Ente;

$controller = new ClapsController();


$model = new Clap();
$modelJefe = new Jefe();
$modelMunicipio = new Municipio();
$modelParroquia = new Parroquia();
$modelBloque = new Bloque();
$modelEnte = new Ente();


if ($_POST) {

    if (!empty($_POST['clap_input_municipio_id'])) {
        $id = $_POST['clap_input_municipio_id'];
        $listarClap = $model->getList('municipios_id', '=', $id);
        $municipio = $modelMunicipio->find($listarClap['municipios_id']);
    } else {
        $listarClap = $model->getAll(1);
    }


    $i = 0;
    $suma = 0;

//recorremos la db y llemanos las columnas
    foreach ($listarClap as $clap) {
        $i++;
        $jefe = $controller->getJefe($clap['id']);
        $municipio = $modelMunicipio->find($clap['municipios_id']);
        $parroquia = $modelParroquia->find($clap['parroquias_id']);
        $bloque = $modelBloque->find($clap['bloques_id']);
        $ente = $modelEnte->find($clap['entes_id']);
        $activeWorksheet->setCellValue('A' . $fila, strtoupper($bloque['numero']));
        $activeWorksheet->setCellValue('B' . $fila, strtoupper($parroquia['nombre']));
        $activeWorksheet->setCellValue('C' . $fila, strtoupper($clap['estracto']));
        $activeWorksheet->setCellValue('D' . $fila, strtoupper($ente['nombre']));
        $activeWorksheet->setCellValue('E' . $fila, $i);
        $activeWorksheet->setCellValue('F' . $fila, strtoupper($clap['nombre']));
        $activeWorksheet->setCellValue('G' . $fila, strtoupper($jefe['genero']));
        $activeWorksheet->setCellValue('H' . $fila, strtoupper($jefe['nombre']));
        $activeWorksheet->setCellValue('I' . $fila, $jefe['cedula']);
        $activeWorksheet->setCellValue('J' . $fila, $jefe['telefono']);
        $activeWorksheet->setCellValue('K' . $fila, $clap['familias']);



        $fila++;
        $suma = $suma + $clap['familias'];

    }
    $activeWorksheet->setCellValue('J' . $fila, 'DESPACHO TOTAL DEL BLOQUE: ');
    $activeWorksheet->setCellValue('K' . $fila, $suma);



} else {
    header('location: ' . ROOT_PATH . 'admin\\claps\\');
}
*/?>

<?php
session_start();
# Declaramos la librería
require '../../../vendor/autoload.php';

use app\controller\ClapsController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use app\model\Clap;
use app\model\Jefe;
use app\model\Municipio;
use app\model\Parroquia;
use app\model\Bloque;
use app\model\Ente;

$controller = new ClapsController();


$model = new Clap();
$modelJefe = new Jefe();
$modelMunicipio = new Municipio();
$modelParroquia = new Parroquia();
$modelBloque = new Bloque();
$modelEnte = new Ente();

$cols = 'style="border: #0a0e14 1px solid; background: yellow;"';
$rows = 'style="border: #0a0e14 1px solid;"';

if ($_POST) {

    if (!empty($_POST['clap_input_municipio_id'])) {
        $id = $_POST['clap_input_municipio_id'];
        $listarClap = $model->getList('municipios_id', '=', $id);
        $municipio = $modelMunicipio->find($id);
        $title = $municipio['nombre'];
    } else {
        $listarClap = $model->getAll(1);
        $title = 'ESTADO GUÁRICO';
    }

    $i = 0;
    $suma = 0;

?>
<div>

    <table>
        <thead>
            <tr>
                <th <?php echo $cols; ?> >BLOQUE</th>
                <th <?php echo $cols; ?> >PARROQUIA</th>
                <th <?php echo $cols; ?> >EXTRACTO</th>
                <th <?php echo $cols; ?> >ENTE ENCARGADO</th>
                <th <?php echo $cols; ?> >Nº</th>
                <th <?php echo $cols; ?> >NOMBRE CLAP</th>
                <th <?php echo $cols; ?> >GÉNERO</th>
                <th <?php echo $cols; ?> >DATOS DEL JEFE DE COMUNIDAD</th>
                <th <?php echo $cols; ?> >CÉDULA</th>
                <th <?php echo $cols; ?> >TELÉFONO</th>
                <th <?php echo $cols; ?> >TOTAL</th>
            </tr>
        </thead>

        <tbody>
        <?php
        foreach ($listarClap as $clap) {
            $i++;
            $jefe = $controller->getJefe($clap['id']);
            $municipio = $modelMunicipio->find($clap['municipios_id']);
            $parroquia = $modelParroquia->find($clap['parroquias_id']);
            $bloque = $modelBloque->find($clap['bloques_id']);
            $ente = $modelEnte->find($clap['entes_id']);
        ?>
            <tr>
                <td <?php echo $rows; ?> > <?php echo $bloque['numero']; ?></td>
                <td <?php echo $rows; ?> > <?php echo mb_strtoupper($parroquia['nombre']) ?></td>
                <td <?php echo $rows; ?> > <?php echo mb_strtoupper($clap['estracto']) ?></td>
                <td <?php echo $rows; ?> > <?php echo mb_strtoupper($ente['nombre']) ?></td>
                <td <?php echo $rows; ?> > <?php echo $i ?></td>
                <td <?php echo $rows; ?> > <?php echo mb_strtoupper($clap['nombre'])?></td>
                <td <?php echo $rows; ?> > <?php echo mb_strtoupper($jefe['genero']) ?></td>
                <td <?php echo $rows; ?> > <?php echo mb_strtoupper($jefe['nombre'])?></td>
                <td <?php echo $rows; ?> > <?php echo $jefe['cedula'] ?></td>
                <td <?php echo $rows; ?> > <?php echo $jefe['telefono'] ?></td>
                <td <?php echo $rows; ?> > <?php echo $clap['familias'] ?></td>

            </tr>
        <?php } ?>
        <tr>
            <td>
                <?php echo $title ?>
            </td>
        </tr>
        </tbody>



    </table>



</div>

<?php
}else{
    header('location: ' . ROOT_PATH . 'admin\\claps\\');
}
?>





