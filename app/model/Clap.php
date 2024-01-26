<?php

namespace app\model;

class Clap extends Model
{

    public function __construct()
    {
        $this->TABLA = "claps";
        $this->DATA = [
            'nombre',
            'estracto',
            'familias',
            'municipios_id',
            'parroquias_id',
            'bloques_id',
            'entes_id',
            'ubch',
            'token'
        ];
    }
}