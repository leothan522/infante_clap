<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Bloque;
use app\model\Ente;
use app\model\Clap;
use app\model\Jefe;

class ClapsController extends Admin
{

    public string $TITTLE = 'Gestionar CLAPS';
    public string $MODULO = 'claps.index';

    public $linksPaginate;
    public $pag = 0;

    public function isAdmin()
    {
        parent::isAdmin(); // TODO: Change the autogenerated stub
        if (!validarPermisos($this->MODULO)) {
            header('location: ' . ROOT_PATH . 'admin\\');
        }
    }


    public function listarBloques($municipio)
    {
        $model = new Bloque();
        $listarBloques = $model->getList('municipios_id', '=', $municipio);
        return $listarBloques;
    }

    public function listarEntes()
    {
        $model = new Ente();
        $listarBloques = $model->getAll();
        return $listarBloques;
    }


    public function listarClaps()
    {
        $model = new Clap();
        $limit = 30;
        $this->linksPaginate = paginate('procesar_claps.php', 'tabla_claps', $limit, $model->count(1), null, 'paginate', 'dataContainerClap')->createLinks();
        return $model->paginate($limit, null, 'id', 'DESC', 1);
    }


}