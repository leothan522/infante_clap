<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\BloquesController;
$controller = new BloquesController();

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            switch ($opcion) {

                //definimos las opciones a procesar
                case 'get_municipios':

                    $response = crearResponse(
                        null,
                        true,
                        null,
                        null,
                        'success',
                        false,
                        true);

                    foreach ($controller->MUNICIPIOS as $municipio) {
                        $id = $municipio['id'];
                        $nombre = $municipio['mini'];
                        if (validarAccesoMunicipio($id)){
                            $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                        }
                    }

                    break;

                case 'index':
                    $paginate = true;
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $controller->index($id);
                        require_once "../_layout/table_bloques.php";
                    } else {
                        echo '<span>Seleccione un Municipio para empezar</span>';
                    }
                    break;

                case 'store':

                    if (!empty($_POST['bloques_numero']) &&
                        !empty($_POST['municipios_id']) &&
                        !empty($_POST['bloques_asignacion']))
                    {
                        //proceso
                        $numero = $_POST['bloques_numero'];
                        $nombre = $_POST['bloques_nombre'];
                        $municipios_id = $_POST['municipios_id'];
                        $asignacion = $_POST['bloques_asignacion'];
                        $response = $controller->store($numero, $nombre, $municipios_id, $asignacion);
                    } else {
                        //manejo el error
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'edit':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->edit($id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'update':

                    if (
                        !empty($_POST['bloques_numero']) &&
                        !empty($_POST['bloques_nombre']) &&
                        !empty($_POST['municipios_id']) &&
                        !empty($_POST['municipios_id'])
                    ) {
                        $numero = $_POST['bloques_numero'];
                        $nombre = $_POST['bloques_nombre'];
                        $asignacion = $_POST['bloques_asignacion'];
                        $municipios_id = $_POST['municipios_id'];
                        $id = $_POST['id'];
                        $response = $controller->update($id, $numero, $nombre, $municipios_id, $asignacion);
                    } else {
                        //manejo el error
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
