<?php

namespace app\model;

class Bloque extends Model
{

    public function __construct()
    {
        $this->TABLA = "bloques";
        $this->DATA = [
            'numero',
            'nombre'
        ];
    }
}