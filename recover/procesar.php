<?php
session_start();
require_once "../vendor/autoload.php";
use app\model\User;

$response = array();

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            $model = new User();

            switch ($opcion) {

                //definimos las opciones a procesar
                case "guardar":

                    if (
                        !empty($_POST['password']) &&
                        !empty($_POST['token'])
                    ){

                        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                        $token = $_POST['token'];
                        $created_at = date('Y-m-d');

                        $existeEmail = $model->existe('token', '=', $token,null, 1);
                        if ($existeEmail){

                            $id = $existeEmail['id'];
                            $model->update($id, 'password', $password);
                            $model->update($id, 'token', null);
                            $model->update($id, 'date_token', null);
                            $model->update($id, 'updated_at', $created_at);

                            $response = crearResponse(
                                null,
                                true,
                                'Contraseña Actualizada.',
                                'Su contraseña se ha restablecido correctamente. Inicie sesión con su nueva clave.',
                                'success',
                                true
                            );


                        }else{
                            $response = crearResponse(
                                'email_duplicado',
                                false,
                                'Token no encontrado.',
                                'El token se encuentra vencido.',
                                'warning',
                                true
                            );
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