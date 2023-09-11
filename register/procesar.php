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
                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = false;
                            $response['icon'] =  "success";
                            $response['title'] = "Guardado.";
                            $response['message'] = "Bienvenido ". $name;

                        }else{
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = 'email_duplicado';
                            $response['icon'] =  "warning";
                            $response['title'] = "Email Duplicado.";
                            $response['message'] = "El email ya esta registrado.";
                        }

                    }else{
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan datos.";
                        $response['message'] = "El nombre del parametro es obligatorio.";
                    }

                    break;



                //Por defecto
                default:
                    $response['result'] = false;
                    $response['alerta'] = true;
                    $response['error'] = "no_opcion";
                    $response['icon'] = "warning";
                    $response['title'] = "Opcion no Programada.";
                    $response['message'] = "No se ha programado la logica para la opcion \"$opcion\"";
                    break;
            }

        } catch (PDOException $e) {
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = 'error_model';
            $response['icon'] = "error";
            $response['title'] = "Error en el Model";
            $response['message'] = "PDOException {$e->getMessage()}";
        } catch (Exception $e) {
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = 'error_model';
            $response['icon'] = "error";
            $response['title'] = "Error en el Model";
            $response['message'] = "General Error: {$e->getMessage()}";
        }
    } else {
        $response['result'] = false;
        $response['alerta'] = true;
        $response['error'] = "faltan_datos";
        $response['icon'] = "warning";
        $response['title'] = "Faltan datos.";
        $response['message'] = "La variable opcion no definida.";
    }
} else {
    $response['result'] = false;
    $response['alerta'] = true;
    $response['error'] = 'error_method';
    $response['icon'] = "error";
    $response['title'] = "Error Method.";
    $response['message'] = "Deben enviarse los datos por el method POST.";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);