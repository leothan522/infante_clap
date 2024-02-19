<?php
namespace app\middleware;

use app\model\Municipio;

class Admin extends Auth
{
    public function isAdmin()
    {
        if (!$this->USER_ROLE) {
            header('location: '. ROOT_PATH.'web\\');
        }
    }

    public function listarmunicipios()
    {
        $model = new Municipio();
        $listarMunicipio = $model->getAll();
        return $listarMunicipio;
    }
}