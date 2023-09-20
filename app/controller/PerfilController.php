<?php
namespace app\controller;

use app\middleware\Admin;

class PerfilController extends Admin
{
    public string $TITTLE = 'Perfil';
    public string $MODULO = 'perfil.index';

}