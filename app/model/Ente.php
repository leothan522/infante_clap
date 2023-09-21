<?php

namespace app\model;

class Ente extends Model
{
    public function __construct()
    {
        $this->TABLA = "entes";
        $this->DATA = [
            'nombre'
        ];
    }

}