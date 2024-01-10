<?php

namespace app\model;

class Parroquia extends Model
{

    public function __construct()
    {
        $this->TABLA = "parroquias";
        $this->DATA = [
            'nombre',
            'mini',
            'municipios_id',
            'familias',
            'created_at'
        ];
    }
}