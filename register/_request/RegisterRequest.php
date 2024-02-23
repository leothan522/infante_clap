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
                case "guardar":

                    if (
                        !empty($_POST['name']) &&
                        !empty($_POST['email']) &&
                        !empty($_POST['password']) &&
                        !empty($_POST['telefono'])
                    ){

                        $name = ucwords($_POST['name']);
                        $email = strtolower($_POST['email']);
                        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                        $telefono = $_POST['telefono'];
                        $created_at = date('Y-m-d');

                        $existeEmail = $model->existe('email', '=', $email,null, 1);
                        if (!$existeEmail){

                            $data = [
                                $name,
                                $email,
                                $password,
                                $telefono,
                                0,
                                $created_at
                            ];

                            $model->save($data);

                            $user = $model->first('email', '=', $email);
                            $_SESSION['id'] = $user['id'];
                            $response = crearResponse(
                                null,
                                true,
                                "Bienvenido ". $name,
                                "Bienvenido ". $name
                            );
                        }else{
                            $response = crearResponse(
                                'email_duplicado',
                                false,
                                'Email Duplicado.',
                                'El email ya esta registrado.',
                                'warning'
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