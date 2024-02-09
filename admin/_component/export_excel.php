<?php
# Declaramos la librería
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

# Agregar contenido al archivo Excel
$spreadsheet = new Spreadsheet();

//configuramos estilos
$styleArray = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'rotation' => 90,
        'startColor' => [
            'argb' => '639cf0',
        ],
        /*'endColor' => [
            'argb' => 'FFFFFFFF',
        ],*/
    ],
];
//$spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($styleArray);
//$spreadsheet->getActiveSheet()->getStyle('B3:B7')->applyFromArray($styleArray);

$spreadsheet->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray);

//agregar valores
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setTitle('Hoja 1');
$activeWorksheet->setCellValue('A2', "Valor A");
$activeWorksheet->setCellValue('B2', 'Hello World !');
$activeWorksheet->getColumnDimension('A')->setAutoSize(true);
$activeWorksheet->getColumnDimension('B')->setAutoSize(true);


# definimos el nombre del archivo
$fileName="Descarga_excel.xlsx";

# Crear un "escritor"
$writer = new Xlsx($spreadsheet);

# Le pasamos la ruta de guardado
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');