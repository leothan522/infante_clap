<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Cuota;

class PagosController extends Admin
{
    public string $TITTLE = 'Validacion de pagos';
    public string $MODULO = 'pagos.index';

    public $linksPaginate;
    public $pag = 0;

    public function isAdmin()
    {
        parent::isAdmin(); // TODO: Change the autogenerated stub
        if (!validarPermisos($this->MODULO)) {
            header('location: ' . ROOT_PATH . 'admin\\');
        }
    }

    public function listarCuotas()
    {
        $model = new Cuota();
        $limit = 12;
        $this->linksPaginate = paginate('procesar_cuotas.php', 'tabla_cuotas', $limit, $model->count(1), null, 'paginate', 'dataContainerCuotas')->createLinks();
        return $model->paginate($limit, null, 'fecha', 'DESC', 1);
    }
}