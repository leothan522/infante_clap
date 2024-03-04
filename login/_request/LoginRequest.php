<?php
session_start();
require_once "../../vendor/autoload.php";
use app\controller\GuestController;
$controller = new GuestController();

$response = array();

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            switch ($opcion) {

                //definimos las opciones a procesar
                case "login":

                    if (!empty($_POST['email']) && !empty($_POST['password'])){
                        $email = strtolower($_POST['email']);
                        $password = $_POST['password'];
                        $response = $controller->login($email, $password);
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
echo json_encode($response, JSON_UNESCAPED_UNICODE);