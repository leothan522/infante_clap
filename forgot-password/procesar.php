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
                            $url = public_url('recover/') . '?token=' . $token . '&email=' . $email_url . '';
                            $hoy = date("Y-m-d H:i:s");


                            //definir variables
                            $asunto = utf8_decode('Reestablecimiento de Contraseña');
                            $html = 'Para restablecer su contraseña siga el siguiente enlace: <strong><a href=' . $url . '>Restablecer Contraseña</a></strong>';
                            $noHtml = 'Para restablecer su contraseña siga el siguiente enlace: ' . $url;

                            //envio correo
                            $mailer = new MailerController();
                            $mailer->enviarEmail($email, $asunto, $html, $noHtml);

                            $model->update($existeEmail['id'], 'token', $token);
                            $model->update($existeEmail['id'], 'date_token', $hoy);

                            $response = crearResponse(
                                null,
                                true,
                                'Correo Enviado.',
                                'Tu nueva contraseña se ha enviado a tu correo.'
                            );

                        } else {
                            $response = crearResponse(
                                'no_email',
                                false,
                                'Email NO encontrado.',
                                'El Email NO se encuentra en nuestros registro.',
                                'error',
                                true
                            );
                        }

                    } else {
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