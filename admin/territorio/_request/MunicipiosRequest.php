<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\TerritorioController;
$controller = new TerritorioController();

use app\model\Municipio;
use app\model\Parroquia;

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];
        $hoy = date('Y-m-d');

        try {

            $model = new Municipio();

            switch ($opcion) {

                //definimos las opciones a procesar


                case 'paginate_municipio':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';
                    $contenDiv = !empty($_POST['contentDiv']) ? $_POST['contentDiv'] : 'dataContainer';

                    $controller->index('municipios', $limit, $totalRows, $offset);
                    require "../_layout/card_table_municipios.php";

                    break;

                case 'store':

                    if (
                        !empty($_POST['mun_municipio']) &&
                        !empty($_POST['municipio_mini']) &&
                        !empty($_POST['municipio_asignacion'])
                    ) {
                        //proceso
                        $nombre = ucwords($_POST['mun_municipio']);
                        $mini = $_POST['municipio_mini'];
                        $asignacion = $_POST['municipio_asignacion'];
                        $response = $controller->store('municipio', $nombre, $mini, $asignacion);

                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'edit':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->edit('municipio', $id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'update':

                    if (
                        !empty($_POST['mun_municipio']) &&
                        !empty($_POST['municipio_mini']) &&
                        !empty($_POST['id'])
                    ) {
                        //proceso
                        $id = $_POST['id'];
                        $nombre = $_POST['mun_municipio'];
                        $mini = $_POST['municipio_mini'];
                        $asignacion = $_POST['municipio_asignacion'];
                        $response = $controller->update('municipios', $id, $nombre, $mini, $asignacion);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'delete':

                    if (!empty($_POST['id'])) {
                        //proceso
                        $id = $_POST['id'];
                        $response = $controller->delete('municipios', $id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'set_estatus':

                    if (!empty($_POST['id'])) {
                        //proceso
                        $id = $_POST['id'];
                        $response = $controller->setEstatus('municipios', $id);
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

if (!$paginate) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
