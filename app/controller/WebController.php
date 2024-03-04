<?php

namespace app\controller;

use app\middleware\Auth;
use app\model\Parametros;

class WebController extends Auth
{
    public function isAdmin()
    {
        if ($this->USER_ROLE) {
            header('location: '. ROOT_PATH.'admin\\');
        }
    }

    public  function verEstatusUsuario($estatus, $icon = true): string
    {
        if (!$icon) {
            $suspendido = "Suspendido";
            $activado = "Activo";
        } else {
            $suspendido = '<i class="fas fa-user-times"></i>';
            $activado = '<i class="fa fa-user-check"></i>';
        }

        $status = [
            '0' => '<span class="text-danger">' . $suspendido . '</span>',
            '1' => '<span class="text-success">' . $activado . '</span>'/*,
        '2' => '<span class="text-success">Confirmado</span>'*/
        ];
        return $status[$estatus];
    }

    public function getRol($role, $role_id): mixed
    {
        switch ($role) {
            case 0:
                $verRole = 'Público';
                break;
            case 1:
                $verRole = 'Estandar';
                break;
            case 99:
                $verRole = 'Administrador';
                break;
            case 100:
                $verRole = 'Root';
                break;
            default:
                $model = new Parametros();
                $rol = $model->find($role_id);
                $verRole = $rol['nombre'];
                break;
        }

        return $verRole;
    }


}