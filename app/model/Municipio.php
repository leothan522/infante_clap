<?php

namespace app\model;

class Municipio extends Model
{
    public function __construct()
    {
        $this->TABLA = "municipios";
        $this->DATA = [
            'nombre',
            'mini',
            'familias',
            'created_at'
        ];
    }
}