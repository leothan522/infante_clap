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


    public function store($nombre, $codigo, $mini): array
    {
        $model = new Banco();
        $existeNombre = $model->existe('nombre', '=', $nombre);
        $existeMini = $model->existe('mini', '=', $mini);
        $existeCodigo = $model->existe('codigo', '=', $codigo);

        if (!$existeNombre && !$existeCodigo && !$existeMini){
            $data = [
                $nombre,
                $mini,
                $codigo
            ];

            $model->save($data);
            $response = crearResponse(
                false,
                true,
                'Guardado Exitosamente',
                'Se Guardo Exitosamente'
            );
            $response['total'] = $model->count();
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

            if ($existeMini){
                $response = crearResponse(
                    'error_mini',
                    false,
                    'Abreviatura Duplicada.',
                    'La abreviatura ya esta registrada.',
                    'warning'
                );
            }

            if ($existeCodigo && $existeNombre && $existeMini){
                $response = crearResponse(
                    'error_nombre_mini_codigo',
                    false,
                    'Datos Duplicado.',
                    'Datos Duplicados.',
                    'warning'
                );
            }
        }


        return $response;

    }

    public function edit($id)
    {
        $model = new Banco();
        $banco = $model->find($id);
        $response = crearResponse(
            false,
            true,
            'Editar Banco',
            'Editar Banco',
            'success',
            false,
            true
        );
        $response['nombre'] = $banco['nombre'];
        $response['mini'] = $banco['mini'];
        $response['codigo'] = $banco['codigo'];
        $response['id'] = $banco['id'];

        return $response;
    }

    public function update($nombre, $mini, $codigo, $id): array
    {
        $model = new Banco();
        $cambios = false;
        $banco = $model->find($id);
        $existeNombre = $model->existe('nombre', '=', $nombre, $id);
        $existeMini = $model->existe('mini', '=', $mini, $id);
        $existeCodigo = $model->existe('codigo', '=', $codigo, $id);

        if (!$existeNombre && !$existeMini && !$existeCodigo){
            $db_nombre = $banco['nombre'];
            $db_mini = $banco['mini'];
            $db_codigo = $banco['codigo'];

            if ($db_nombre != $nombre){
                $cambios = true;
                $model->update($id, 'nombre', $nombre);
            }

            if ($db_mini != $mini){
                $cambios = true;
                $model->update($id, 'mini', $mini);
            }

            if ($db_codigo != $codigo){
                $cambios = true;
                $model->update($id, 'codigo', $codigo);
            }

            if ($cambios){
                $response = crearResponse(
                    false,
                    true,
                    'Editado Exitosamente',
                    'Editado Exitosamente'
                );
                $banco = $model->find($id);
                $response['nombre_banco'] = $banco['nombre'];
                $response['mini_banco'] = $banco['mini'];
                $response['codigo_banco'] = $banco['codigo'];
                $response['total'] = $model->count();
            }else{
                $response = crearResponse('no_cambios');
            }

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

            if ($existeMini){
                $response = crearResponse(
                    'error_mini',
                    false,
                    'Abreviatura Duplicada.',
                    'La abreviatura ya esta registrada.',
                    'warning'
                );
            }

            if ($existeCodigo && $existeNombre && $existeMini){
                $response = crearResponse(
                    'error_nombre_mini_codigo',
                    false,
                    'Datos Duplicado.',
                    'Datos Duplicados.',
                    'warning'
                );
            }
        }
        return $response;

    }

    public function delete($id)
    {
        $model = new Banco();
        $model->delete($id);

        $response = crearResponse(
            null,
            true,
            'Banco Eliminado.',
            'Banco Eliminado.'
        );
        $response['total'] = $model->count();
        return $response;
    }

}