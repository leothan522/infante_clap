<?php
# Declaramos la librería
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

# Agregar contenido al archivo Excel
$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setTitle('Hoja 1');
$activeWorksheet->setCellValue('A1', "Valor A");
$activeWorksheet->setCellValue('B1', 'Hello World !');

# definimos el nombre del archivo
$fileName="Descarga_excel.xlsx";

# Crear un "escritor"
$writer = new Xlsx($spreadsheet);

# Le pasamos la ruta de guardado
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');