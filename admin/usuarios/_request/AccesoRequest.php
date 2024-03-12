<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\AccesosController;
$controller = new AccesosController();

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

                    $controller->index($baseURL, $tableID, $limit, $totalRows, $offset);
                    require_once '../_layout/card_table_acceso.php';

                    break;

                case 'get_user':
                    $response = $controller->getUser();
                    break;

                case 'index':
                    $paginate = true;
                    $controller->index();
                    require_once '../_layout/card_table_acceso.php';

                    break;

               case 'update':

                    if (!empty($_POST['usuario']) && !empty($_POST['municipios'])) {

                        $id = $_POST['usuario'];
                        $municipios = $_POST['municipios'];
                        $response = $controller->update($id, $municipios);
                    } else {
                        $response = crearResponse('faltas_datos');
                    }

                    break;

                case 'destroy':

                    if (!empty($_POST['id'])) {

                        $id = $_POST['id'];
                       $response = $controller->destroy($id);
                    } else {
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
