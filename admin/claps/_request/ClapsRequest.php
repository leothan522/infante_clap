<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\ClapsController;
$controller = new ClapsController();

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
                    $valor = !empty($_POST['valor']) ? $_POST['valor'] : '';

                    //vistas a renderizar
                    $controller->index($valor, $baseURL, $tableID, $limit, $totalRows, $offset);
                    require('../_layout/card_listar_claps.php');

                    break;

                case 'index':

                    $paginate = true;
                    if (!empty($_POST['id'])) {
                        //proceso
                        $id = $_POST['id'];
                        $controller->index($id);
                    }
                    require('../_layout/card_listar_claps.php');

                    break;

                case 'create':
                    $response = $controller->create();
                    break;

                case 'change_municipio':
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->changeMunicipio($id);
                    } else {
                        $response['result'] = crearResponse('faltan_datos');
                    }
                    break;

                case 'store':

                    if (
                        !empty($_POST['clap_select_municipio']) &&
                        !empty($_POST['clap_select_parroquia']) &&
                        !empty($_POST['clap_select_bloque']) &&
                        !empty($_POST['clap_select_estracto']) &&
                        !empty($_POST['clap_input_nombre']) &&
                        !empty($_POST['clap_input_familias']) &&
                        !empty($_POST['clap_select_entes']) &&
                        !empty($_POST['jefe_input_cedula']) &&
                        !empty($_POST['jefe_input_nombre']) &&
                        !empty($_POST['jefe_select_genero']) &&
                        !empty($_POST['jefe_input_telefono'])
                    ) {

                        $municipio = $_POST['clap_select_municipio'];
                        $parroquia = $_POST['clap_select_parroquia'];
                        $bloque = $_POST['clap_select_bloque'];
                        $estracto = $_POST['clap_select_estracto'];
                        $clap_nombre = $_POST['clap_input_nombre'];
                        $familias = $_POST['clap_input_familias'];
                        $entes = $_POST['clap_select_entes'];
                        $cedula = $_POST['jefe_input_cedula'];
                        $jefe_nombre = $_POST['jefe_input_nombre'];
                        $genero = $_POST['jefe_select_genero'];
                        $telefono = $_POST['jefe_input_telefono'];
                        $ubch = $_POST['clap_ubch'];
                        $email = $_POST['jefe_input_email'];
                        $response = $controller->store(
                            $clap_nombre,
                            $estracto,
                            $familias,
                            $municipio,
                            $parroquia,
                            $bloque,
                            $entes,
                            $ubch,
                            $cedula,
                            $jefe_nombre,
                            $telefono,
                            $genero,
                            $email
                        );

                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'show':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->show($id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'edit_clap':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->editClap($id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'update_clap':

                    if (
                        !empty($_POST['clap_edit_select_municipio']) &&
                        !empty($_POST['clap_edit_select_parroquia']) &&
                        !empty($_POST['clap_edit_select_bloque']) &&
                        !empty($_POST['clap_edit_select_estracto']) &&
                        !empty($_POST['clap_edit_input_nombre']) &&
                        !empty($_POST['clap_edit_input_familias']) &&
                        !empty($_POST['clap_edit_select_entes'])
                    ) {
                        $municipio = $_POST['clap_edit_select_municipio'];
                        $parroquia = $_POST['clap_edit_select_parroquia'];
                        $bloque = $_POST['clap_edit_select_bloque'];
                        $estracto = $_POST['clap_edit_select_estracto'];
                        $nombre = $_POST['clap_edit_input_nombre'];
                        $familias = $_POST['clap_edit_input_familias'];
                        $entes = $_POST['clap_edit_select_entes'];
                        $ubch = $_POST['clap_edit_ubch'];
                        $id = $_POST['clap_edit_id'];
                        $response = $controller->updateClap(
                            $id,
                            $nombre,
                            $estracto,
                            $familias,
                            $municipio,
                            $parroquia,
                            $bloque,
                            $entes,
                            $ubch
                        );

                    } else {
                        $response = crearResponse(
                            "fantan_datos",
                            false,
                            'Faltan datos',
                            'faltan datos',
                            'warning'
                        );
                    }

                    break;

                case 'edit_jefe':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->editJefe($id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'update_jefe':

                    if (
                        !empty($_POST['jefe_edit_input_cedula']) &&
                        !empty($_POST['jefe_edit_input_nombre']) &&
                        !empty($_POST['jefe_edit_select_genero']) &&
                        !empty($_POST['jefe_edit_input_telefono'])
                    ) {
                        $cedula = $_POST['jefe_edit_input_cedula'];
                        $nombre = $_POST['jefe_edit_input_nombre'];
                        $genero = $_POST['jefe_edit_select_genero'];
                        $telefono = $_POST['jefe_edit_input_telefono'];
                        $email = $_POST['jefe_edit_input_email'];
                        $id = $_POST['jefe_edit_id'];
                        $response = $controller->updateJefe($id, $cedula, $nombre, $telefono, $genero, $email);
                    } else {
                        $response = crearResponse("fantan_datos");
                    }

                    break;

                case 'delete':

                    if (!empty($_POST['id'])) {
                        //proceso
                        $id = $_POST['id'];
                        $response = $controller->delete($id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'nabvar_buscar':

                    $paginate = true;

                    if (!empty($_POST['keyword'])) {
                        //proceso
                        $id = $_POST['id'];
                        $keyword = $_POST['keyword'];
                        $controller->search($keyword, $id);
                        $buscar = true;
                    }
                    require('../_layout/card_listar_claps.php');

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
