<?php
session_start();
require_once "../../vendor/autoload.php";
use app\model\User;

$response = array();

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            $model = new User();

            switch ($opcion) {

                //definimos las opciones a procesar
                case "login":

                    if (
                        !empty($_POST['email']) &&
                        !empty($_POST['password'])
                    ){

                        $email = strtolower($_POST['email']);
                        $password = $_POST['password'];

                        $existeEmail = $model->existe('email', '=', $email, null, 1);
                        if ($existeEmail){

                            $id = $existeEmail['id'];
                            $name = $existeEmail['name'];
                            $db_password = $existeEmail['password'];
                            $band = $existeEmail['band'];
                            $estatus = $existeEmail['estatus'];

                            if (password_verify($password, $db_password)) {

                                if ($estatus) {
                                    $_SESSION['id'] = $id;
                                    $response = crearResponse(
                                        null,
                                        true,
                                        "Bienvenido ". $name,
                                        "Bienvenido ". $name
                                    );
                                } else {
                                    $response = crearResponse(
                                        'no_activo',
                                        false,
                                        'Usuario Inactivo.',
                                        'Usuario Inactivo. Contacte a su Administrador.',
                                        'error',
                                        false
                                    );
                                }

                            }else{
                                $response = crearResponse(
                                    'no_password',
                                    false,
                                    'Contreseña invalida.',
                                    'La contraseña es incorrecta.',
                                    'error',
                                    false
                                );
                            }

                        }else{
                            $response = crearResponse(
                                'no_email',
                                false,
                                'Email NO encontrado.',
                                'El Email NO se encuentra en nuestros registro.',
                                'error',
                                false);
                        }

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