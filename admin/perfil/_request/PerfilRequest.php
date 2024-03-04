<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\PerfilController;
$controller = new PerfilController();


$response = array();

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            switch ($opcion) {

                //definimos las opciones a procesar
                case 'update':

                    if (
                        !empty($_POST['name']) &&
                        !empty($_POST['email']) &&
                        !empty($_POST['telefono']) &&
                        !empty($_POST['password'])
                    ) {
                        //datos recibidospor el POST
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $telefono = $_POST['telefono'];
                        $password = $_POST['password'];
                        $response = $controller->update($password, $name, $email, $telefono);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case "set_password":

                    if (
                        !empty($_POST['contrasea_actual']) &&
                        !empty($_POST['contrasea_nueva'])
                    ) {
                        $old_password = $_POST['contrasea_actual'];
                        $new_password = $_POST['contrasea_nueva'];
                        $response = $controller->setPassword($old_password, $new_password);
                    } else {
                        //manejo los errores
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

