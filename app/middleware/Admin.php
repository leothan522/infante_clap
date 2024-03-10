<?php
namespace app\middleware;

use app\model\Municipio;

class Admin extends Auth
{
    public $MUNICIPIOS;

    public function isAdmin()
    {
        if (!$this->USER_ROLE) {
            header('location: '. ROOT_PATH.'web\\');
        }
    }

    public function mountMunicipios()
    {
        $model = new Municipio();
        $this->MUNICIPIOS = $model->getAll();
    }
}