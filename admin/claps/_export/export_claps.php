<?php
# Declaramos la librería
require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use app\model\Clap;
use app\model\Jefe;
use app\model\Municipio;
use app\model\Parroquia;
use app\model\Bloque;
use app\model\Ente;

$model = new Clap();
$modelJefe = new Jefe();
$modelMunicipio = new Municipio();
$modelParroquia = new Parroquia();
$modelBloque = new Bloque();
$modelEnte = new Ente();

$listarJefes = $modelJefe->getAll(1);

# Agregar contenido al archivo Excel
$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setTitle('Hoja 1');
$activeWorksheet->setCellValue('A1', "#");
$activeWorksheet->setCellValue('B1', "Nombre CLAP");
$activeWorksheet->setCellValue('C1', 'Estracto');
$activeWorksheet->setCellValue('D1', 'Familias');
$activeWorksheet->setCellValue('E1', 'Municipio');
$activeWorksheet->setCellValue('F1', 'Parroquias');
$activeWorksheet->setCellValue('G1', 'Bloque');
$activeWorksheet->setCellValue('H1', 'Ente');
$activeWorksheet->setCellValue('I1', 'UBCH');
$activeWorksheet->setCellValue('J1', 'Cédula Jefe');
$activeWorksheet->setCellValue('K1', 'Nombre Jefe');
$activeWorksheet->setCellValue('L1', 'Género');
$activeWorksheet->setCellValue('M1', 'Email');

//AUTOAJUSTAR LAS COLUMNAS
$activeWorksheet->getColumnDimension('A')->setAutoSize(true);
$activeWorksheet->getColumnDimension('B')->setAutoSize(true);
$activeWorksheet->getColumnDimension('C')->setAutoSize(true);
$activeWorksheet->getColumnDimension('D')->setAutoSize(true);
$activeWorksheet->getColumnDimension('E')->setAutoSize(true);
$activeWorksheet->getColumnDimension('F')->setAutoSize(true);
$activeWorksheet->getColumnDimension('G')->setAutoSize(true);
$activeWorksheet->getColumnDimension('H')->setAutoSize(true);
$activeWorksheet->getColumnDimension('I')->setAutoSize(true);
$activeWorksheet->getColumnDimension('J')->setAutoSize(true);
$activeWorksheet->getColumnDimension('K')->setAutoSize(true);
$activeWorksheet->getColumnDimension('L')->setAutoSize(true);
$activeWorksheet->getColumnDimension('M')->setAutoSize(true);

$fila = 2;

//recorremos la db y llemanos las columnas
foreach ($listarJefes as $jefe){
    $clap = $model->find($jefe['claps_id']);
    $municipio = $modelMunicipio->find($clap['municipios_id']);
    $parroquia = $modelParroquia->find($clap['parroquias_id']);
    $bloque = $modelBloque->find($clap['bloques_id']);
    $ente = $modelEnte->find($clap['entes_id']);
    $activeWorksheet->setCellValue('A'. $fila, $clap['id']);
    $activeWorksheet->setCellValue('B'. $fila, $clap['nombre']);
    $activeWorksheet->setCellValue('C'. $fila, $clap['estracto']);
    $activeWorksheet->setCellValue('D'. $fila, formatoMillares($clap['familias'], 0));
    $activeWorksheet->setCellValue('E'. $fila, $municipio['nombre']);
    $activeWorksheet->setCellValue('F'. $fila, $parroquia['nombre']);
    $activeWorksheet->setCellValue('G'. $fila, $bloque['nombre']);
    $activeWorksheet->setCellValue('H'. $fila, $ente['nombre']);
    $activeWorksheet->setCellValue('I'. $fila, $clap['ubch']);
    $activeWorksheet->setCellValue('J'. $fila, formatoMillares($jefe['cedula'], 0));
    $activeWorksheet->setCellValue('K'. $fila, $jefe['nombre']);
    $activeWorksheet->setCellValue('L'. $fila, $jefe['genero']);
    $activeWorksheet->setCellValue('M'. $fila, $jefe['email']);

    $fila++;
}

# definimos el nombre del archivo
$fileName="Datos_Claps.xlsx";

# Crear un "escritor"
$writer = new Xlsx($spreadsheet);

# Le pasamos la ruta de guardado
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');