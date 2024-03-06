<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\TerritorioController;
$controller  = new TerritorioController();

use app\model\Parroquia;
use app\model\Municipio;

$response = array();
$paginate = false;
$controller = new TerritorioController();

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];
        $hoy = date('Y-m-d');

        try {

            $model = new Parroquia();

            switch ($opcion) {

                //definimos las opciones a procesar

                case 'paginate_parroquias':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';
                    $contenDiv = !empty($_POST['contentDiv']) ? $_POST['contentDiv'] : 'dataContainer';

                    $controller->index('parroquia', $limit, $totalRows, $offset);
                    require "../_layout/card_table_parroquias.php";

                    break;

                case 'store':

                    $modelMunicipio = new Municipio();

                    if (
                        !empty($_POST['parroquia_municipio']) &&
                        !empty($_POST['parroquia_nombre']) &&
                        !empty($_POST['parroquia_mini'])
                    ) {
                        //declaramos en variables lo que resivimos por el metodo post
                        $municipio = $_POST['parroquia_municipio'];
                        $nombre = ucwords($_POST['parroquia_nombre']);
                        $mini = $_POST['parroquia_mini'];
                        $asignacion = $_POST['parroquia_asignacion'];
                        $response = $controller->store('parroquia', $nombre, $mini, $asignacion, $municipio);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'edit':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->edit('parroquia', $id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'update':

                    $modelMunicipio = new Municipio();
                    if (
                        !empty($_POST['parroquia_municipio']) &&
                        !empty($_POST['parroquia_nombre']) &&
                        !empty($_POST['id']) &&
                        !empty($_POST['parroquia_mini']) &&
                        !empty($_POST['parroquia_asignacion'])
                    ) {
                        $municipio = $_POST['parroquia_municipio'];
                        $nombre = $_POST['parroquia_nombre'];
                        $id = $_POST['id'];
                        $mini = $_POST['parroquia_mini'];
                        $asignacion = $_POST['parroquia_asignacion'];
                        $response = $controller->update('parroquia', $id, $nombre, $mini, $asignacion, $municipio);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'delete':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->delete('parroquia', $id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'set_estatus':

                    $model = new Parroquia();
                    if(!empty($_POST['id'])) {
                        //proceso
                        $id = $_POST['id'];
                        $response = $controller->setEstatus('parroquia', $id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'get_municipios':

                    $response = $controller->getMunicipios();

                    break;

                case 'get_parroquias':
                    $paginate = true;
                    $model = new Parroquia();
                    $limit = 100;
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $controller->getParroquias($id);
                        $restablecer = true;
                    }else{
                        $controller->index('parroquia');
                        $restablecer = false;
                    }
                    require_once "../_layout/card_table_parroquias.php";
                    break;

                case 'search':
                    $paginate = true;

                    if (!empty($_POST['keyword'])){
                        $keyword = $_POST['keyword'];
                        $controller->search($keyword, 'parroquias');
                        require "../_layout/card_table_parroquias.php";
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

if (!$paginate) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

