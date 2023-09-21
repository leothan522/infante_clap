<?php

namespace app\model;

class despacho extends Model
{

    public function __construct()
    {
        $this->TABLA = "despachos";
        $this->DATA = [
          'fecha',
          'notas'
        ];
    }
}