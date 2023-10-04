<?php
use app\model\User;

function validarPermisos($key = null): bool
{
    $model = new User();
    $user = $model->find($_SESSION['id']);
    $acceso = false;

    if (
        ((leerJson($user['permisos'], $key) || $user['role'] == 99) && ($user['band'] == 1 && $user['estatus'] == 1)) ||
        $user['role'] == 100
    ){
        $acceso = true;
    }

    if ($key == "root" && $user['role'] != 100){
        $acceso = false;
    }

    return $acceso;
}