<?php

namespace app\model;

class Banco extends Model
{
    public function __construct()
    {
        $this->TABLA = "bancos";
        $this->DATA = [
            'nombre',
            'codigo'
        ];
    }

}