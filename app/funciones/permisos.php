<?php
use app\middleware\Auth;

function validarPermisos($key = null): bool
{
    $auth = new Auth();
    $acceso = false;

    if ((leerJson($auth->USER_PERMISOS, $key) && $auth->USER_BAND == 1) || $auth->USER_ROLE > 98){
        $acceso = true;
    }

    if ($key == "root" && $auth->USER_ROLE != 100){
        $acceso = false;
    }

    return $acceso;
}