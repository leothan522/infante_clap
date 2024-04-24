<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\BancosController;
$controller = new BancosController();

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
                    $contenDiv = !empty($_POST['contentDiv']) ? $_POST['contentDiv'] : 'dataContainer';

                    //vistas a renderizar
                    //require ...
                    $controller->index($baseURL, $tableID, $limit, $totalRows, $offset, $opcion, $contenDiv);
                    require "../_layout/card_table_bancos.php";

                    break;

                case 'index':
                    $paginate = true;
                    $controller->index();
                    require "../_layout/card_table_bancos.php";

                    break;

                case 'store':
                    if (
                        !empty($_POST['bancos_form_nombre']) &&
                        !empty($_POST['bancos_form_mini']) &&
                        !empty($_POST['bancos_form_codigo'])
                    ){
                        $nombre = $_POST['bancos_form_nombre'];
                        $codigo = $_POST['bancos_form_codigo'];
                        $mini = $_POST['bancos_form_mini'];

                        $response = $controller->store($nombre, $codigo, $mini);
                        if ($response['result']){
                            $paginate = true;
                            $controller->index();
                            require '../_layout/card_table_bancos.php';
                        }

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
                        !empty($_POST['bancos_form_nombre']) &&
                        !empty($_POST['bancos_form_mini']) &&
                        !empty($_POST['bancos_form_codigo']) &&
                        !empty($_POST['bancos_id'])
                    ){
                        $nombre = $_POST['bancos_form_nombre'];
                        $mini = $_POST['bancos_form_mini'];
                        $codigo = $_POST['bancos_form_codigo'];
                        $id = $_POST['bancos_id'];
                        $response = $controller->update($nombre, $mini, $codigo, $id);
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

if (!$paginate){
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
