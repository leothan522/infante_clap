<?php

namespace app\model;

class Pago extends Model
{

    public function __construct()
    {
        $this->TABLA = "pagos";
        $this->DATA = [
            'monto',
            'referencia',
            'cuotas_id',
            'claps_id'
        ];
    }
}