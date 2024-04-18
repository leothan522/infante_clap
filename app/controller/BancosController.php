<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Banco;

class BancosController extends Admin
{
    public $links;
    public $rows;
    public $limit;
    public $totalRows;
    public $offset;

    public function index(
        $baseURL = '_request/BancosRequest.php',
        $tableID = 'table_bancos',
        $limit = null,
        $totalRows = null,
        $offset = null
    ){
        $model = new Banco();

        if (is_null($limit)) {
            $this->limit = numRowsPaginate();
        } else {
            $this->limit = $limit;
        }
        if (is_null($totalRows)) {
            $this->totalRows = $model->count();
        } else {
            $this->totalRows = $totalRows;
        }
        $this->offset = $offset;

        $this->links = paginate(
            $baseURL,
            $tableID,
            $this->limit,
            $this->totalRows,
            $offset
        )->createLinks();

        $this->rows = $model->paginate(
            $this->limit,
            $offset,
            'id',
            'DESC'
        );

    }


    public function store($nombre, $codigo): array
    {
        $model = new Banco();
        $existeNombre = $model->existe('nombre', '=', $nombre);
        $existeCodigo = $model->existe('codigo', '=', $codigo);

        if (!$existeNombre && !$existeCodigo){
            $data = [
                $nombre,
                $codigo
            ];

            $model->save($data);
            $response = crearResponse(
                false,
                true,
                'Guardado Exitosamente',
                'Se Guardo Exitosamente'
            );
        }else{


            if ($existeNombre){
                $response = crearResponse(
                    'error_nombre',
                    false,
                    'Nombre Duplicado.',
                    'El nombre ya esta registrado.',
                    'warning'
                );

            }

            if ($existeCodigo){
                $response = crearResponse(
                    'error_codigo',
                    false,
                    'Codigo Duplicado.',
                    'El codigo ya esta registrado.',
                    'warning'
                );
            }

            if ($existeCodigo && $existeNombre){
                $response = crearResponse(
                    'error_nombre_codigo',
                    false,
                    'Datos Duplicado.',
                    'Datos Duplicados.',
                    'warning'
                );
            }
        }


        return $response;

    }

}