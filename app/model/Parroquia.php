<?php

namespace app\model;

class Parroquia extends Model
{

    public function __construct()
    {
        $this->TABLA = "parroquias";
        $this->DATA = [
            'municipios_id',
            'nombre'
        ];
    }
}