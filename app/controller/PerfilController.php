<?php
namespace app\controller;

use app\middleware\Admin;
use app\model\User;

class PerfilController extends Admin
{
    public string $TITTLE = 'Perfil';
    public string $MODULO = 'perfil.index';

    public function update($password, $name, $email, $telefono)
    {
        $model = new User();
        //datos DATABASE
        $id = $this->USER_ID;
        $user = $model->find($id);
        $updated_at = date("Y-m-d");

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
        return $response;
    }

    public function setPassword($old_password, $new_password)
    {
        $model = new User();
        $updated_at = date("Y-m-d");
        $id = $this->USER_ID;
        $user = $model->find($id);

        if (password_verify($old_password, $user['password'])) {
            if (strlen($new_password) >= 7) {
                if (!password_verify($new_password, $user['password'])) {

                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $model->update($id, 'password', $new_password);
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
        return $response;

    }

}