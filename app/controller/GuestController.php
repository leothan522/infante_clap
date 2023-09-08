<?php

namespace app\controller;

use app\model\User;

class GuestController
{
    public $token;

    public function index(): void
    {
        if (isset($_SESSION['id'])){
            header('location:'. ROOT_PATH.'admin\\');
        }
    }

    public function login($email, $password): array
    {
        $model = new User();
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
        return $response;
    }

    public function recover(): void
    {
        $this->index();

        if (isset($_GET['token']) && isset($_GET['email'])){


            $token = $_GET['token'];
            $email = $_GET['email'];
            $model = new User();
            $existeEmail = $model->existe('email', '=', $email,null,1);

            if ($existeEmail){
                $db_token = $existeEmail['token'];
                $db_date_token = $existeEmail['date_token'];
                $id = $existeEmail['id'];
                $hoy = date("Y-m-d H:i:s");
                $this->token = compararFechas($db_date_token, $hoy);

                if (compararFechas($db_date_token, $hoy) == 0){
                    if ($token == $db_token){
                        $this->token = $token;
                    }else{
                        header('location:'. ROOT_PATH.'login\\');
                    }

                }else{
                    $model->update($id, 'date_token', null);
                    $model->update($id, 'token', null);
                    header('location:'. ROOT_PATH.'login\\');
                }



            }else{
                header('location:'. ROOT_PATH.'login\\');
            }
        }else{
            header('location:'. ROOT_PATH.'login\\');
        }
    }

    public function setPassword($token, $password, $created_at): array
    {
        $model = new User();
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
        return $response;
    }

    public function register($name, $email, $password, $telefono, $created_at): array
    {
        $model = new User();
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
        return $response;
    }

    public function forgotPassword($email): array
    {
        $model = new User();
        $existeEmail = $model->existe('email', '=', $email);
        if ($existeEmail) {

            $token = generar_string_aleatorio(50);
            $email_url = str_replace('@', '%40', $email);
            $url = public_url('recover/') . '?token=' . $token . '&email=' . $email_url . '';
            $hoy = date("Y-m-d H:i:s");

            //definir variables
            $asunto = verUtf8('Reestablecimiento de Clave');
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
        return $response;
    }

}