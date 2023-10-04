<?php
namespace app\model;

use app\model\Model;

class Parametros extends Model
{
    public function __construct()
    {
        $this->TABLA = "parametros";
        $this->DATA = [
           'nombre',
           'tabla_id',
           'valor'
        ];
    }
}