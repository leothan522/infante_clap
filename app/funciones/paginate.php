<?php
// Include pagination library file
use app\controller\PaginationController;

function paginate($baseURL, $tableID, $limit, $rowCount, $offset = null, $opcion = 'paginate', $contentDiv = 'dataContainer')
{
    // Set some useful configuration
    //$baseURL = 'getData.php';
    //$limit = 1;
    //$rowCount = $persona->count();
    // Initialize pagination class
    $pagConfig = array(
        'baseURL' => $baseURL,
        'tableID' => $tableID,
        'totalRows' => $rowCount,
        'perPage' => $limit,
        'currentPage' => $offset,
        'contentDiv' => $contentDiv,
        'opcion' => $opcion
    );
    $pagination = new PaginationController($pagConfig);
    return $pagination;
}

//procesar.php
/*if (isset($_POST['page'])) {
    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';
    $pagination = paginate($baseURL, $tableID, $limit, $totalRows, $offset);
}*/