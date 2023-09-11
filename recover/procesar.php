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


                            $response['result'] = true;
                            $response['alerta'] = true;
                            $response['error'] = false;
                            $response['icon'] =  "success";
                            $response['title'] = "Contraseña Actualizada.";
                            $response['message'] = "Su contraseña se ha restablecido correctamente. Inicie sesión con su nueva clave";

                        }else{
                            $response['result'] = false;
                            $response['alerta'] = true;
                            $response['error'] = 'email_duplicado';
                            $response['icon'] =  "warning";
                            $response['title'] = "Token no encontrado.";
                            $response['message'] = "El token se encuentra vencido.";
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