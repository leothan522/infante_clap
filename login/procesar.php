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
                case "login":

                    if (
                        !empty($_POST['email']) &&
                        !empty($_POST['password'])
                    ){

                        $email = strtolower($_POST['email']);
                        $password = $_POST['password'];

                        $existeEmail = $model->existe('email', '=', $email);
                        if ($existeEmail){

                            $id = $existeEmail['id'];
                            $name = $existeEmail['name'];
                            $db_password = $existeEmail['password'];
                            $band = $existeEmail['band'];

                            if (password_verify($password, $db_password)) {

                                if ($band) {
                                    $_SESSION['id'] = $id;
                                    $response['result'] = true;
                                    $response['alerta'] = false;
                                    $response['error'] = false;
                                    $response['icon'] =  "success";
                                    $response['title'] = "Guardado.";
                                    $response['message'] = "Bienvenido ". $name;
                                } else {
                                    $response['result'] = false;
                                    $response['alerta'] = false;
                                    $response['error'] = 'no_activo';
                                    $response['icon'] =  "error";
                                    $response['title'] = "Usuario Inactivo.";
                                    $response['message'] = "Usuario Inactivo. Contacte a su Administrador.";
                                }

                            }else{
                                $response['result'] = false;
                                $response['alerta'] = false;
                                $response['error'] = 'no_password';
                                $response['icon'] =  "error";
                                $response['title'] = "Contreseña invalida.";
                                $response['message'] = "La contraseña es incorrecta.";
                            }

                        }else{
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = 'no_email';
                            $response['icon'] =  "error";
                            $response['title'] = "Email NO encontrado.";
                            $response['message'] = "El Email NO se encuentra en nuestros registro.";
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