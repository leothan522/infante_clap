<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Bloque;

class ClapsController extends Admin
{

    public string $TITTLE = 'Gestionar CLAPS';
    public string $MODULO = 'claps.index';

    public function isAdmin()
    {
        parent::isAdmin(); // TODO: Change the autogenerated stub
        if (!validarPermisos($this->MODULO)){
            header('location: '. ROOT_PATH.'admin\\');
        }
    }

   public function listarBloques($municipio){
        $model = new Bloque();
        $listarBloques = $model->getList('municipios_id', '=', $municipio);
        return $listarBloques;
    }

}