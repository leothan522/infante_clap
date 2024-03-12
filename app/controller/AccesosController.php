<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Municipio;
use app\model\User;

class AccesosController extends Admin
{
    public $rows;
    public $totalRows;
    public $links;
    public $limit;
    public $offset;

    public function index(
        $baseURL = '_request/AccesoRequest.php',
        $tableID = 'usuario_table_acceso',
        $limit = null,
        $totalRows = null,
        $offset = null
    )
    {
        $model = new User();
        if (is_null($limit)) {
            $this->limit = numRowsPaginate();
        } else {
            $this->limit = $limit;
        }
        if (is_null($totalRows)) {
            $this->totalRows = $model->count(1, 'acceso_municipio', '!=', 'null');
        } else {
            $this->totalRows = $totalRows;
        }
        $this->offset = $offset;

        $this->links = paginate(
            $baseURL,
            $tableID,
            $this->limit,
            $this->totalRows,
            $offset,
            'paginate',
            'usuario_card_table',
            '_acceso',
            'acceso_municipio',
            '!=',
            'null'
        )->createLinks();

        $this->rows = $model->paginate(
            $this->limit,
            $offset,
            'id',
            'DESC',
            1,
            'acceso_municipio',
            '!=',
            'null');

    }

    public function getUser(): array
    {
        $model = new User();
        $modelMunicipio = new municipio();
        $response = crearResponse(false, true, false, false, 'success', false, true);
        foreach ($modelMunicipio->getAll() as $municipio) {
            $id = $municipio['id'];
            $nombre = $municipio['mini'];
            $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
        }

        foreach ($model->getAll(1) as $user) {
            $id = $user['id'];
            $email = $user['email'];
            $nombre = $user['name'];
            $response['usuarios'][] = array("id" => $id, "email" => $email, "name" => $nombre);
        }
        return $response;
    }

    public function update($usuarios, $municipios)
    {
        $model = new User();
        $user = $model->find($usuarios);

        $accesos = array();
        $listarMunicipios = array();
        $modelmunicipio = new Municipio();
        foreach ($municipios as $municipio) {
            $getMunicipio = $modelmunicipio->find($municipio);
            $accesos[] = $municipio;
            $listarMunicipios[] = " ".$getMunicipio['mini'];
        }

        $model->update($usuarios, 'acceso_municipio', crearJson($accesos));

        $count = $model->count(1, 'acceso_municipio', '!=', 'null');

        $response = crearResponse(
            null,
            true,
            'Datos Guardados.',
            "Mostrando Usuario " . $user['name']
        );
        //datos extras para el response
        $response['id'] = $user['id'];
        $response['name'] = $user['name'];
        $response['email'] = $user['email'];
        $response['municipios'] = $listarMunicipios;
        $response['item'] = $count;
        $response['total'] = $count;

        if (is_null($user['acceso_municipio'])){
            $response['remove'] = false;
        }else{
            $response['remove'] = true;
        }
        return $response;
    }

    public function destroy($id)
    {
        $model = new User();
        $user = $model->find($id);

        if ($user) {

            $model->update($id, 'acceso_municipio', null);

            $count = $model->count(1, 'acceso_municipio', '!=', 'null');

            $response = crearResponse(
                null,
                true,
                'Acceso Eliminado.',
                'Acceso Eliminado.'
            );
            //datos extras para el $response
            $response['total'] = $model->count(1, 'acceso_municipio', '!=', 'null');

        } else {
            $response = crearResponse(
                'no_user',
                false,
                'Usuario NO encontrado."',
                'El id del usuario no esta disponible.',
                'warning',
                true
            );
        }
        return $response;

    }

    public function getMunicipio($id): mixed
    {
        $model = new Municipio();
        $municipio = $model->find($id);
        return $municipio['mini'];

    }


}