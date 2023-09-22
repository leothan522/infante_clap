<?php

namespace app\model;

class Despacho extends Model
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