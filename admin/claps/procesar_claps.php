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

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {
            $model = new Clap();
            switch ($opcion) {

                //definimos las opciones a procesar

                case 'get_municipios_select':
                    $modelMunicipio = new Municipio();

                    $response = crearResponse(
                        null,
                        true,
                        'Exito.',
                        'Exito.',
                        'success',
                        false,
                        true
                    );

                    $response['municipios'] = array();
                    foreach ($modelMunicipio->getAll() as $municipio) {
                        $id = $municipio['id'];
                        $nombre = $municipio['mini'];
                        $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    $modelEnte = new Ente();
                    $response['entes'] = array();
                    foreach ($modelEnte->getAll(null, 'nombre') as $ente) {
                        $id = $ente['id'];
                        $nombre = $ente['nombre'];
                        $response['entes'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    break;

                case 'get_bloque_parroquia':
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];

                        $response = crearResponse(
                            null,
                            true,
                            'Exito.',
                            'Exito.',
                            'success',
                            false,
                            true
                        );

                        $modelBloque = new Bloque();
                        $response['bloques'] = array();
                        foreach ($modelBloque->getList('municipios_id', '=', $id, null, 'numero') as $bloque) {
                            $id = $bloque['id'];
                            $nombre = $bloque['numero'];
                            $response['bloques'][] = array("id" => $id, "nombre" => $nombre);
                        }

                        $modelParroquia = new Parroquia();
                        $response['parroquias'] = array();
                        foreach ($modelParroquia->getList('municipios_id', '=', $id) as $parroquia) {
                            $id = $parroquia['id'];
                            $nombre = $parroquia['nombre'];
                            $response['parroquias'][] = array("id" => $id, "nombre" => $nombre);
                        }

                    } else {
                        $response['result'] = crearResponse('faltan_datos');
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
