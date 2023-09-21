<?php

namespace app\model;

class Jefe extends Model
{

    public function __construct()
    {
        $this->TABLA = "jefes";
        $this->DATA = [
            'cedula',
            'nombre',
            'telefono',
            'genero',
            'claps_id'
        ];
    }
}