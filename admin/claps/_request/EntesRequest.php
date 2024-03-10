<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\EntesController;
$controller = new EntesController();

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            switch ($opcion) {

                //definimos las opciones a procesar

                case 'index':

                    $paginate = true;
                    $controller->index();
                    require '../_layout/table_entes.php';

                    break;

                case 'store':

                    if (!empty($_POST['entes_nombre'])){
                        $nombre = $_POST['entes_nombre'];
                        $response = $controller->store($nombre);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'edit':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $response = $controller->edit($id);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'update':

                    if (!empty($_POST['entes_nombre'])){
                        $nombre = $_POST['entes_nombre'];
                        $id = $_POST['id'];
                        $response = $controller->update($id, $nombre);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'delete':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->delete($id);
                    } else {
                        //manejo el error
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
