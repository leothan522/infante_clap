<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Clap;
use app\model\Municipio;
use app\model\Bloque;
use app\model\Parroquia;
use app\model\Ente;

$response = array();
$paginate = false;

if ($_POST) try {
    if (!empty($_POST['opcion'])) {
        $opcion = $_POST['opcion'];
        $model = new Clap();
        switch ($opcion) {

            //definimos las opciones a procesar

            case 'get_municipios_select':
                $modelMunicipio = new Municipio();
                $response['municipios'] = array();
                foreach ($modelMunicipio->getAll() as $municipio){
                    $id = $municipio['id'];
                    $nombre = $municipio['mini'];
                    $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                }

                $modelEnte = new Ente();
                $response['entes'] = array();
                foreach ($modelEnte->getAll(null, 'nombre') as $ente){
                    $id = $ente['id'];
                    $nombre = $ente['nombre'];
                    $response['entes'][] = array("id" => $id, "nombre" => $nombre);
                }

                $response['result'] = true;
                break;

                case 'get_bloque_parroquia':
                if (!empty($_POST['id'])){
                    $id = $_POST['id'];

                    $modelBloque = new Bloque();
                    $response['bloques'] = array();
                    foreach ($modelBloque->getList('municipios_id', '=', $id, null, 'numero') as $bloque){
                        $id = $bloque['id'];
                        $nombre = $bloque['numero'];
                        $response['bloques'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    $modelParroquia = new Parroquia();
                    $response['parroquias'] = array();
                    foreach ($modelParroquia->getList('municipios_id', '=', $id) as $parroquia){
                        $id = $parroquia['id'];
                        $nombre = $parroquia['nombre'];
                        $response['parroquias'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    $response['result'] = true;
                    $response['alerta'] = false;
                    $response['error'] = false;
                    $response['icon'] = "success";
                    $response['title'] = "Exito.";
                    $response['message'] = "exito";
                }else{
                    $response['result'] = false;
                    $response['alerta'] = true;
                    $response['error'] = "no_municipio";
                    $response['icon'] = "warning";
                    $response['title'] = "Faltan datos.";
                    $response['message'] = "Primero se debe seleccionar un municipio";
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
