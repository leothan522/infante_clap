<?php
session_start();
require_once "../../vendor/autoload.php";

use app\database\Query;
use app\model\User;
use app\controller\UsersController;

$controller = new UsersController();
$response = array();

if ($_POST) {
    $model = new User();
    try {
        if (!empty($_POST['opcion'])) {
            $opcion = $_POST['opcion'];


            switch ($opcion) {

                //definimos las opciones a procesar
                case 'editar_datos':

                    if (
                        !empty($_POST['name']) &&
                        !empty($_POST['email']) &&
                        !empty($_POST['telefono']) &&
                        !empty($_POST['password'])
                    ){
                        //datos recibidospor el POST
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $telefono = $_POST['telefono'];
                        $password = $_POST['password'];
                        $updated_at = date("Y-m-d");

                        //datos DATABASE
                        $id = $controller->USER_ID;
                        $user = $model->find($id);


                        if (password_verify($password, $user['password'])){
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

                            if ($cambios){
                                //sucess
                                $model->update($id, 'updated_at', $updated_at);
                                $response['result'] = true;
                                $response['alerta'] = false;
                                $response['error'] = 'cambios';
                                $response['icon'] = "success";
                                $response['title'] = "Cambios guardados.";
                                $response['message'] = "Cambios guardados exitosamente.";
                            }else{
                                //manejo el error
                                $response['result'] = false;
                                $response['alerta'] = true;
                                $response['error'] = "no_cambios";
                                $response['icon'] = "info";
                                $response['title'] = "Sin Cambios.";
                                $response['message'] = "No se realizo ningun cambio.";
                            }
                        }else{
                            //manejo el error
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = "no_password";
                            $response['icon'] = "error";
                            $response['title'] = "Contraseña Incorrecta.";
                            $response['message'] = "Se debe ingresar la contraseña actual.";
                        }
                    }else{
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan datos.";
                        $response['message'] = "La variable opcion no definida.";
                    }

                    break;

                case "editar_seguridad":

                    if (
                        !empty($_POST['contrasea_actual']) &&
                        !empty($_POST['contrasea_nueva']) &&
                        !empty($_POST['confirmar'])
                    ){
                        $contrasea_actual = $_POST['contrasea_actual'];
                        $contrasea_nueva = $_POST['contrasea_nueva'];
                        $confirmar = $_POST['confirmar'];
                        $updated_at = date("Y-m-d");
                        $id = $controller->USER_ID;
                        $get_user = $model->find($id);

                        if (password_verify($contrasea_actual, $get_user['password'])){
                            if (strlen($contrasea_nueva) >= 7){
                                if (!password_verify($contrasea_nueva, $get_user['password'])){
                                    $contrasea_nueva = password_hash($contrasea_nueva, PASSWORD_DEFAULT);
                                    $model->update($id, 'password', $contrasea_nueva);
                                    $model->update($id, 'updated_at', $updated_at);

                                    $response['result'] = true;
                                    $response['alerta'] = false;
                                    $response['error'] = 'cambios';
                                    $response['icon'] =  "success";
                                    $response['title'] = "Cambios guardados.";
                                    $response['message'] = "Cambios guardados exitosamente.";

                                }else{
                                    $response['result'] = false;
                                    $response['alerta'] = true;
                                    $response['error'] = 'password_iguales';
                                    $response['icon'] =  "error";
                                    $response['title'] = "Contraseña nueva incorrecta.";
                                    $response['message'] = "El contraseña nueva no debe ser igual a la contraseña anterior.";
                                }

                            }else{
                                $response['result'] = false;
                                $response['alerta'] = false;
                                $response['error'] = 'no_password_tamaño';
                                $response['icon'] =  "error";
                                $response['title'] = "Contraseña nueva incorrecta.";
                                $response['message'] = "El contraseña es obligatoria, debe tener al menos 8 caracteres.";
                            }
                        }else {
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = 'no_password';
                            $response['icon'] =  "error";
                            $response['title'] = "Contraseña actual incorrecta.";
                            $response['message'] = "La contraseña actual es incorrecta.";
                        }


                    }else{
                        //manejo los errores
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan datos.";
                        $response['message'] = "Revisar los input enviados.";
                    }

                    break;


                //Por defecto
                default:
                    $response['result'] = false;
                    $response['alerta'] = true;
                    $response['error'] = "no_opcion";
                    $response['icon'] = "warning";
                    $response['title'] = "Opcion no Programada.";
                    $response['message'] = "No se ha programado la logica para la case \"$opcion\":";
                    break;

            }


        } else {
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = "faltan_datos";
            $response['icon'] = "warning";
            $response['title'] = "Faltan datos.";
            $response['message'] = "La variable opcion no definida.";
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
    $response['error'] = 'error_method';
    $response['icon'] = "error";
    $response['title'] = "Error Method.";
    $response['message'] = "Deben enviarse los datos por el method POST.";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);

