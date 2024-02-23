<?php
session_start();
require_once "../../vendor/autoload.php";

use app\controller\WebController;
use app\model\User;
$response = array();
$paginate = false;
$controller = new WebController();
$model = new User();

if ($_POST) {

    if (!empty($_POST['opcion'])) {
        $opcion = $_POST['opcion'];

        try {

            switch ($opcion) {
                //definimos las opciones a procesar
                case 'ir_dashboard':

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

                //definimos las opciones a procesar
                case 'editar_datos':

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
                        $updated_at = date("Y-m-d");

                        //datos DATABASE
                        $id = $controller->USER_ID;
                        $user = $model->find($id);


                        if (password_verify($password, $user['password'])) {
                            //variable local
                            $cambios = false;

                            if ($user['name'] != $name) {
                                $cambios = true;
                                $model->update($id, 'name', $name);
                            }

                            if ($user['email'] != $email) {
                                $cambios = true;
                                $model->update($id, 'email', $email);
                            }

                            if ($user['telefono'] != $telefono) {
                                $cambios = true;
                                $model->update($id, 'telefono', $telefono);

                            }

                            if ($cambios) {
                                //sucess
                                $model->update($id, 'updated_at', $updated_at);
                                $user = $model->find($id);
                                $response = crearResponse(
                                    null,
                                    true,
                                    'Cambios guardados.',
                                    'Cambios guardados exitosamente.'
                                );
                                $response['nombre'] = $user['name'];
                                $response['email'] = $user['email'];
                                $response['telefono'] = $user['telefono'];
                            } else {
                                //manejo el error
                                $response = crearResponse('no_cambios');
                            }

                        } else {
                            //manejo el error
                            $response = crearResponse(
                                'no_password',
                                false,
                                'Contraseña Incorrecta.',
                                'Se debe ingresar la contraseña actual.',
                                'error',
                            );
                        }
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case "editar_seguridad":

                    if (
                        !empty($_POST['contrasea_actual']) &&
                        !empty($_POST['contrasea_nueva']) &&
                        !empty($_POST['confirmar'])
                    ) {
                        $contrasea_actual = $_POST['contrasea_actual'];
                        $contrasea_nueva = $_POST['contrasea_nueva'];
                        $confirmar = $_POST['confirmar'];
                        $updated_at = date("Y-m-d");
                        $id = $controller->USER_ID;
                        $get_user = $model->find($id);

                        if (password_verify($contrasea_actual, $get_user['password'])) {
                            if (strlen($contrasea_nueva) >= 7) {
                                if (!password_verify($contrasea_nueva, $get_user['password'])) {
                                    $contrasea_nueva = password_hash($contrasea_nueva, PASSWORD_DEFAULT);
                                    $model->update($id, 'password', $contrasea_nueva);
                                    $model->update($id, 'updated_at', $updated_at);

                                    $response = crearResponse(
                                        null,
                                        true,
                                        'Cambios guardados.',
                                        'Cambios guardados exitosamente.',
                                    );

                                } else {
                                    $response = crearResponse(
                                        'password_iguales',
                                        false,
                                        'Contraseña nueva incorrecta.',
                                        'El contraseña nueva no debe ser igual a la contraseña anterior.',
                                        'error',
                                        true
                                    );
                                }

                            } else {
                                $response = crearResponse(
                                    'no_password_tamaño',
                                    false,
                                    'Contraseña nueva incorrecta.',
                                    'El contraseña es obligatoria, debe tener al menos 8 caracteres.',
                                    'error',
                                );
                            }
                        } else {
                            $response = crearResponse(
                                'no_password',
                                false,
                                'Contraseña actual incorrecta.',
                                'La contraseña actual es incorrecta.',
                                'error',
                            );
                        }


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

if (!$paginate) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

