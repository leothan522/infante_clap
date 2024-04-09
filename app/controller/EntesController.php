<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Clap;
use app\model\Ente;

class EntesController extends Admin
{
    public $rows;

    public function index()
    {
        $model = new Ente();
        $this->rows = $model->getAll();
    }

    public function store($nombre): array
    {
        $model = new Ente();
        $existe = $model->existe('nombre', '=', $nombre);

        if (!$existe){

            $data = [
                $nombre
            ];

            $model->save($data);
            $entes = $model->first('nombre', '=', $nombre);
            $response = crearResponse(
                null,
                true,
                'Ente registrado.',
                'El nombre se registro perfectamente.'
            );
            $response['id'] = $entes['id'];
            $response['item'] = '<p class="text-center"> ' . $model->count() . ' </p>';
            $response['nombre'] = '<p class="text-uppercase"> ' . $entes['nombre'] . ' </p>';
            $response['nuevo'] = true;
            $response['total'] = $model->count();
        }else{
            $response = crearResponse(
                'nombre_duplicado',
                false,
                'Nombre duplicado.',
                'El nombre ya se encuentra registrado.',
                'warning'
            );
        }

        return $response;
    }

    public function edit($id): array
    {
        $model = new Ente();
        $ente = $model->find($id);
        $response = crearResponse(
            null,
            true,
            'Editar Ente.',
            'Editar Ente.',
            'success',
            false,
            false
        );
        $response['id'] = $ente['id'];
        $response['nombre'] = $ente['nombre'];
        return $response;
    }

    public function update($id, $nombre): array
    {
        $model = new Ente();
        $existe = $model->existe('nombre', '=', $nombre, $id);

        if (!$existe){
            $bloques = $model->find($id);
            if ($bloques['nombre'] != $nombre){
                $model->update($id,'nombre', $nombre);
                $ente = $model->first('nombre', '=', $nombre);
                $response = crearResponse(
                    null,
                    true,
                    'Ente Actualizado Exitosamente.',
                    'El nombre se actualizo perfectamente.'
                );
                $response['id'] = $ente['id'];
                $response['nombre'] = '<p class="text-uppercase"> ' . $ente['nombre'] . ' </p>';
                $response['total'] = $model->count();
                $response['item'] = '<p class="text-center"> ' . $model->count() . ' </p>';
                $response['nuevo'] = false;
            }else{
                $response = crearResponse('no_cambios');
                $response['item'] = $model->count();
            }
        }else{
            $response = crearResponse(
                'nombre_duplicado',
                false,
                'Nombre duplicado.',
                'El nombre ya se encuentra registrado.',
                'warning'
            );
        }
        return $response;
    }

    public function delete($id): array
    {
        $vinculado = false;
        $modelClap = new Clap();
        $existeClap = $modelClap->existe('entes_id', '=', $id);

        if ($existeClap){
            $vinculado = true;
            $response = crearResponse('vinculado');
        }else{
            $model = new Ente();
            $model->delete($id);
            $response = crearResponse(
                null,
                true,
                'Ente Eliminado.',
                'El ente se ha eliminado exitosamente.'
            );
        }
        return $response;
    }

}