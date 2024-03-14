<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\CuotasController;
$controller = new CuotasController();

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
                    require '../_layout/table_cuotas.php';

                    break;

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

                case 'get_precio':
                    if (empty($_POST['id'])){
                        $id = -1;
                    }else{
                        $id = $_POST['id'];
                    }
                    $response = $controller->getPrecio($id);
                    break;

                case 'index':
                    $paginate = true;

                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $controller->index($id);
                        require '../_layout/table_cuotas.php';
                    }else{
                        echo '<div class="card-body"><span>Seleccione un Municipio para empezar</span></div>';
                    }
                    break;

                case 'store':

                    if (
                        !empty($_POST['cuotas_select_mes']) &&
                        !empty($_POST['cuotas_input_fecha'] &&
                        !empty($_POST['municipios_id'])
                        )
                    ){
                        $mes = $_POST['cuotas_select_mes'];
                        $fecha = $_POST['cuotas_input_fecha'];
                        $municipios_id = $_POST['municipios_id'];
                        $precio = $_POST['cuotas_input_precio'];
                        $adicional = $_POST['cuotas_input_adicional'];
                        $response = $controller->store($mes, $fecha, $precio, $adicional, $municipios_id);
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

                    if (
                        !empty($_POST['cuotas_select_mes']) &&
                        !empty($_POST['cuotas_input_fecha']) &&
                        !empty($_POST['cuotas_id'] &&
                        !empty($_POST['municipios_id'])
                        )
                    ){
                        $mes = $_POST['cuotas_select_mes'];
                        $fecha = $_POST['cuotas_input_fecha'];
                        $precio = $_POST['cuotas_input_precio'];
                        $adicional = $_POST['cuotas_input_adicional'];
                        $municipios_id = $_POST['municipios_id'];
                        $id = $_POST['cuotas_id'];
                        $response = $controller->update($id, $mes, $fecha, $precio, $adicional, $municipios_id);
                    }else{
                        $response = crearResponse('faltan_datos');
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
