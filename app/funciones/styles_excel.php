<?php

//en esta funcion estoy recibiendo la hoja, el rango de celdas para conbinar y centrar, la celda para cambiar el
//tamaño, el tamaño de la letra, la celda para cambiar la fuente, y el tipo de fuente
function combinarCentrarExcel($hoja,$rango, $celda_size = null, $size = null, $celda_fuente = null, $fuente = null, $celda_negrita = null){
    $hoja->mergeCells($rango);
    $hoja->getStyle($rango)->getAlignment()->setHorizontal('center');
    $hoja->getStyle($rango)->getAlignment()->setVertical('center');
    $hoja->getStyle($celda_size)->getFont()->setSize($size);
    $hoja->getStyle($celda_fuente)->getFont()->setName($fuente);
    $hoja->getStyle($celda_negrita)->getFont()->setBold(true);
}

function combinarCelda($hoja, $rango, $celda_size = null, $size = null){
    $hoja->mergeCells($rango);
    $hoja->getStyle($celda_size)->getFont()->setSize($size);
}

//funcion para colocar bordes a una celda
function bordeCeldaExcel($hoja, $celda_borde){
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ];

    $hoja->getStyle($celda_borde)->applyFromArray($styleArray);
}


//funcion para cambiar el color de fondo de una celda
function fondoCeldaExcelAzul($hoja, $celda_fondo){
    $styleArray = [
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'argb' => '3c65ad', // Color de fondo en formato ARGB
            ],
        ],
        'font' => [
            'bold' => true,  // Aplicar negrita
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,  // Centrar el texto horizontalmente
        ],
    ];

// Aplicar el estilo a una celda específica
    $hoja->getStyle($celda_fondo)->applyFromArray($styleArray);
}

function fondoCeldaExcel($hoja, $celda_fondo, $color){
   switch ($color){
       case 'amarillo':
           $styleArray = [
               'fill' => [
                   'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                   'startColor' => [
                       'argb' => 'FAFA37', // Color de fondo en formato ARGB
                   ],
               ],
           ];
           break;
       case 'azul':
           $styleArray = [
               'fill' => [
                   'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                   'startColor' => [
                       'argb' => '0048BA', // Color de fondo en formato ARGB
                   ],
               ],
           ];
       case 'verde':
           $styleArray = [
               'fill' => [
                   'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                   'startColor' => [
                       'argb' => '3AA655', // Color de fondo en formato ARGB
                   ],
               ],
           ];
       case 'rojo':
           $styleArray = [
               'fill' => [
                   'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                   'startColor' => [
                       'argb' => 'ED0A3F', // Color de fondo en formato ARGB
                   ],
               ],
           ];
           case 'naranja':
           $styleArray = [
               'fill' => [
                   'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                   'startColor' => [
                       'argb' => 'FF9933', // Color de fondo en formato ARGB
                   ],
               ],
           ];
           break;
   }

// Aplicar el estilo a una celda específica
    $hoja->getStyle($celda_fondo)->applyFromArray($styleArray);
}




//funcion para autoajustar las columnas
function autoajustarColumnas($hoja, $columnas){
    foreach ($columnas as $column) {
        $hoja->getColumnDimension($column)->setAutoSize(true);
    }
}


//funcion para cambiar el color de una fuente
function cambiarColorFuenteExcel($hoja, $celda, $color) {
    $font = $hoja->getStyle($celda)->getFont();

    switch ($color) {
        case "blanco":
            $font->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
            break;
        case "rojo":
            $font->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED));
            break;
        case "azul":
            $font->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE));
            break;
        case "verde":
            $font->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN));
            break;
        case "amarillo":
            $font->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW));
            break;
        default:
            $font->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
            break;
    }
}

//con esta funcion agregamos el formato millares a una columna
function agregarFormatoMillares($hoja, $columna, $decimales = false) {
    if ($decimales){
        $hoja->getStyle($columna)->getNumberFormat()->setFormatCode('#,##0.00');
    }else{
        $hoja->getStyle($columna)->getNumberFormat()->setFormatCode('#,##0');
    }

}

//con esta funcion puedo alinear las celdas o las columnas
function alineartextoExcel($hoja, $columna, $alineacion){
    switch ($alineacion){
        case 'derecha':
            $hoja->getStyle($columna)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            break;
        case 'izquierda':
            $hoja->getStyle($columna)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            break;
        case 'centro':
            $hoja->getStyle($columna)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            break;
        case 'justificado':
            $hoja->getStyle($columna)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY);
            break;
        default:
            $hoja->getStyle($columna)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            break;
    }
}


