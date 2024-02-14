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


if ($_POST){

    if (!empty($_POST['clap_input_municipio_id'])) {
        $id = $_POST['clap_input_municipio_id'];
        $listarClap = $model->getList('municipios_id', '=', $id);
        $municipio = $modelMunicipio->find($id);
        $title = $municipio['nombre'];
    }else {
        $listarClap = $model->getAll(1);
        $title = 'ESTADO GUÁRICO';
    }

# Agregar contenido al archivo Excel
    $spreadsheet = new Spreadsheet();
    $activeWorksheet = $spreadsheet->getActiveSheet();

    //configuramos estilos
    combinarCelda($activeWorksheet, 'A1:B1', 'A1', 10);
    combinarCelda($activeWorksheet, 'A2:B2', 'A2', 10);
    combinarCentrarExcel($activeWorksheet,'A3:K3','A3', 12, 'A3', 'Calibri', 'A3');
    $activeWorksheet->getRowDimension(6)->setRowHeight(40);
    $activeWorksheet->getStyle('A6:K6')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('A6:K6')->getAlignment()->setVertical('center');
    bordeCeldaExcel($activeWorksheet, 'A6:K6');
    fondoCeldaExcelAzul($activeWorksheet, 'A6:K6');
    cambiarColorFuenteExcel($activeWorksheet, 'A6:K6', 'blanco');
    agregarFormatoMillares($activeWorksheet, 'K', true);
    agregarFormatoMillares($activeWorksheet, 'I');
    alineartextoExcel($activeWorksheet, 'A:K', 'centro');
    alineartextoExcel($activeWorksheet, 'A1', 'izquierda');
    alineartextoExcel($activeWorksheet, 'A2', 'izquierda');

    //pasarle datos
    $activeWorksheet->setTitle('Claps');
    $activeWorksheet->setCellValue('A1', 'Fecha: '. date('d-m-Y H:i'));
    $activeWorksheet->setCellValue('A2', 'Usuario: '. $controller->USER_NAME);
    if (!empty($id)){
        $activeWorksheet->setCellValue('A3', 'DISTRIBUCION DE MODULOS CLAP A FAMILIAS DEL MUNICIPIO ' . $title);
    }else{
        $activeWorksheet->setCellValue('A3', "DISTRIBUCION DE MODULOS CLAP A FAMILIAS DEL ". $title);
    }
    $activeWorksheet->setCellValue('A6', 'BLOQUE');
    $activeWorksheet->setCellValue('B6', 'PARROQUIA');
    $activeWorksheet->setCellValue('C6', 'EXTRACTO');
    $activeWorksheet->setCellValue('D6', 'ENTE ENCARGADO');
    $activeWorksheet->setCellValue('E6', "Nº");
    $activeWorksheet->setCellValue('F6', "NOMBRE CLAP");
    $activeWorksheet->setCellValue('G6', 'GÉNERO');
    $activeWorksheet->setCellValue('H6', 'DATOS DEL JEFE DE COMUNIDAD');
    $activeWorksheet->setCellValue('I6', 'CÉDULA');
    $activeWorksheet->setCellValue('J6', 'TELÉFONO');
    $activeWorksheet->setCellValue('K6', 'TOTAL');

//AUTOAJUSTAR LAS COLUMNAS
    $columnas_ajustar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'];
    autoajustarColumnas($activeWorksheet, $columnas_ajustar);

    $fila = 7;
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

         bordeCeldaExcel($activeWorksheet, 'A' . $fila . ':K' . $fila);
         fondoCeldaExcel($activeWorksheet, 'F'. $fila, 'amarillo');
         fondoCeldaExcel($activeWorksheet, 'K'. $fila, 'naranja');

         $fila++;
         $suma = $suma + $clap['familias'];

     }
    $activeWorksheet->setCellValue('J'. $fila, 'DESPACHO TOTAL DEL BLOQUE: '  );
    $activeWorksheet->setCellValue('K'. $fila, $suma );
    bordeCeldaExcel($activeWorksheet, 'J'. $fila);
    bordeCeldaExcel($activeWorksheet, 'K'. $fila);
    fondoCeldaExcel($activeWorksheet, 'J'. $fila, 'amarillo');
    fondoCeldaExcel($activeWorksheet, 'K'. $fila, 'amarillo');

# definimos el nombre del archivo
    if (!empty($id)){
        $fileName = 'Datos_Claps_'.$municipio['mini'].'_'.date('d-m-Y').'.xlsx';
    }else{
        $fileName = 'Datos_Claps_Estado_Guárico'.date('d-m-Y').'.xlsx';
    }

# Crear un "escritor"
    $writer = new Xlsx($spreadsheet);

# Le pasamos la ruta de guardado
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
    $writer->save('php://output');


}else{
    header('location: '. ROOT_PATH. 'admin\\claps\\');
}




