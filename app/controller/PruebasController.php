<?php

namespace app\controller;

use app\middleware\Admin;

class PruebasController extends Admin
{
    public string $TITTLE = 'Pruebas';
    public string $MODULO = 'pruebas';

    public function isAdmin()
    {
        parent::isAdmin(); // TODO: Change the autogenerated stub
        if (!validarPermisos($this->MODULO)) {
            header('location: ' . ROOT_PATH . 'admin\\');
        }
    }
}