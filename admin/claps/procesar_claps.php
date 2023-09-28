<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Clap;

$response = array();
$paginate = false;

if ($_POST) try {
    if (!empty($_POST['opcion'])) {
        $opcion = $_POST['opcion'];
        $model = new Clap();
        switch ($opcion) {

            //definimos las opciones a procesar

            case 'get_municipios_select':
                $response['result'] = true;
                $response['municipios'] = array();
                foreach ($model->getAll(1) as $municipio){
                    $id = $municipio['id'];
                    $nombre = $municipio['nombre'];
                    $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                }

                break;

            //Por defecto
            default:
                $response['result'] = false;
                $response['alerta'] = true;
                $response['error'] = "no_opcion";
                $response['icon'] = "warning";
                $response['title'] = "Opcion no Programada.";
                $response['message'] = "No se ha programado la logica para la case \"$opcion\":";
                break;

        }


    } else {
        $response['result'] = false;
        $response['alerta'] = true;
        $response['error'] = "faltan_datos";
        $response['icon'] = "warning";
        $response['title'] = "Faltan datos.";
        $response['message'] = "La variable opcion no definida.";
    }
} catch (PDOException $e) {
    $response['result'] = false;
    $response['alerta'] = true;
    $response['error'] = 'error_model';
    $response['icon'] = "error";
    $response['title'] = "Error en el Model";
    $response['message'] = "PDOException {$e->getMessage()}";
} catch (Exception $e) {
    $response['result'] = false;
    $response['alerta'] = true;
    $response['error'] = 'error_model';
    $response['icon'] = "error";
    $response['title'] = "Error en el Model";
    $response['message'] = "General Error: {$e->getMessage()}";
} else {
    $response['result'] = false;
    $response['alerta'] = true;
    $response['error'] = 'error_method';
    $response['icon'] = "error";
    $response['title'] = "Error Method.";
    $response['message'] = "Deben enviarse los datos por el method POST.";
}

if (!$paginate) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
