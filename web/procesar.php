<?php
session_start();
require_once "../vendor/autoload.php";

use app\controller\WebController;
$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {
        $opcion = $_POST['opcion'];

        try {

            switch ($opcion) {
                //definimos las opciones a procesar
                case 'ir_dashboard':
                    $controller = new WebController();
                    if ($controller->USER_ROLE){
                        $response = crearResponse(
                            null,
                            true,
                            '',
                            '',
                            'success',
                            false,
                        true
                        );
                    }else{
                        $response = crearResponse(
                            'no_admin',
                            false,
                            'No tienes permisos suficientes.',
                            '',
                            'error'
                        );
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

