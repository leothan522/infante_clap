<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\ParametrosController;
$controller = new ParametrosController();

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            switch ($opcion) {

                //definimos las opciones a procesar

                case 'paginate':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';
                    $contenDiv = !empty($_POST['contentDiv']) ? $_POST['contentDiv'] : 'dataContainer';

                    $controller->index($baseURL, $tableID, $limit, $totalRows, $offset, $opcion, $contenDiv);
                    require "../_layout/table.php";

                    break;

                case 'index':

                    $paginate = true;
                    $controller->index();
                    require_once "../_layout/table.php";

                    break;

                case 'store':

                    $paginate = true;

                    if (!empty($_POST['name'])) {
                        $name = $_POST['name'];
                        $tabla_id = $_POST['tabla_id'];
                        $valor = $_POST['valor'];
                        $controller->store($name, $tabla_id, $valor);
                        $controller->index();
                        require '../_layout/table.php';
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case "edit":

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->edit($id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case "update":

                    if (!empty($_POST['name'] && !empty($_POST['id']))) {
                        $nombre = $_POST['name'];
                        $tabla_id = $_POST['tabla_id'];
                        $valor = $_POST['valor'];
                        $id = $_POST['id'];
                        $response = $controller->update($id, $nombre, $tabla_id, $valor);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case "delete":

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->delete($id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'search':

                    $paginate = true;

                    if (!empty($_POST['keyword'])){
                        $keyword = $_POST['keyword'];
                        $controller->search($keyword);
                        require "../_layout/table.php";
                    }else{
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                //Por defecto
                default:
                    $response = crearResponse('no_opcion', false, null, $opcion);
                    break;
            }

        } catch (PDOException $e) {
            $response = crearResponse('error_excepcion', false, null, "PDOException {$e->getMessage()}");
        } catch (Exception $e) {
            $response = crearResponse('error_excepcion', false, null, "General Error: {$e->getMessage()}");
        }

    } else {
        $response = crearResponse('error_opcion');
    }
} else {
    $response = crearResponse('error_method');
}

if (!$paginate){
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
