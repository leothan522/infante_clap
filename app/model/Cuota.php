<?php

namespace app\model;

class Cuota extends Model
{

    public function __construct()
    {
        $this->TABLA = "cuotas";
        $this->DATA = [
          'fecha',
          'notas'
        ];
    }
}