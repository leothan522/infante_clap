<?php
session_start();
require_once "../vendor/autoload.php";

use app\model\User;
use app\controller\MailerController;

$response = array();

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            $model = new User();

            switch ($opcion) {

                //definimos las opciones a procesar
                case "forgot_password":

                    if (
                        !empty($_POST['email'])
                    ) {

                        $email = strtolower($_POST['email']);

                        $existeEmail = $model->existe('email', '=', $email);
                        if ($existeEmail) {


                            $token = generar_string_aleatorio(50);
                            $email_url = str_replace('@', '%40', $email);
                            $url = public_url('recover/').'?token='.$token.'&email='.$email_url.'';
                            $hoy = date("Y-m-d H:i:s");


                            //definir variables
                            $asunto = utf8_decode('Reestablecimiento de Contraseña');
                            $html = 'Para restablecer su contraseña siga el siguiente enlace: <strong><a href='.$url.'>Restablecer Contraseña</a></strong>';
                            $noHtml = 'Para restablecer su contraseña siga el siguiente enlace: '. $url ;

                            //envio correo
                            $mailer = new MailerController();
                            $mailer->enviarEmail($email, $asunto, $html, $noHtml);

                            $model->update($existeEmail['id'], 'token', $token);
                            $model->update($existeEmail['id'], 'date_token', $hoy);



                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = false;
                            $response['icon'] =  "success";
                            $response['title'] = "Correo Enviado.";
                            $response['message'] = "Tu nueva contraseña se ha enviado a tu correo.";


                        } else {
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = 'no_email';
                            $response['icon'] = "error";
                            $response['title'] = "Email NO encontrado.";
                            $response['message'] = "El Email NO se encuentra en nuestros registro.";
                        }

                    } else {
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