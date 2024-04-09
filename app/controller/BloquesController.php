<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Bloque;
use app\model\Clap;
use app\model\Municipio;

class BloquesController extends Admin
{
    public $rows;

    public function __construct()
    {
        $this->mountMunicipios();
    }

    public function index($municipio)
    {
        $model = new Bloque();
        $this->rows = $model->getList('municipios_id', '=', $municipio);
    }

    public function store($numero, $nombre, $municipios_id, $asignacion): array
    {
        $model = new Bloque();
        $modelMunicipio = new Municipio();

        $bloques = $model->first('municipios_id', '=', $municipios_id);

        $getBloques = $model->getList('municipios_id', '=', $municipios_id);
        $existe = false;
        $error_numero = false;
        $error_nombre = false;
        $error_asignacion = false;
        foreach ($getBloques as $bloque) {
            $db_nombre = $bloque['nombre'];
            $db_numero = $bloque['numero'];
            $db_asignacion = $bloque['familias'];
            if ($db_nombre == $nombre) {
                $existe = true;
                $error_nombre = true;
            }
            if ($db_numero == $numero) {
                $existe = true;
                $error_numero = true;
            }

            if ($db_asignacion == $asignacion && $db_asignacion != 0) {
                $existe = true;
                $error_asignacion = true;
            }
        }

        $getMunicipio = $modelMunicipio->find($municipios_id);
        $asignacionMax = $getMunicipio['familias'];
        $getParroquias = $model->getList('municipios_id', '=', $municipios_id);
        $suma = 0;

        foreach ($getParroquias as $getParroquia){
            $suma = $suma + $getParroquia['familias'];
        }

        $asignacionCargar = $suma + $asignacion;

        if (empty($nombre)){
            $nombre = 'Bloque ' . $numero;
        }

        if (!$existe && $asignacionMax >= $asignacionCargar) {
            $data = [
                $numero,
                $nombre,
                $municipios_id,
                $asignacion
            ];

            $model->save($data);
            $bloque = $model->first('numero', '=', $numero);
            $response = crearResponse(
                null,
                true,
                'Guardado exitosamente.',
                'Bloque guardado exitosamente.'
            );
            $response['id'] = $bloque['id'];
            $response['item'] = $model->count();
            $response['numero'] = $bloque['numero'];
            $response['nombre'] = '<p class="text-center">'.$bloque['nombre'].'</p>';
            $response['municipios_id'] = $bloque['municipios_id'];
            $response['asignacion'] = '<p class="text-right">'.formatoMillares($bloque['familias']).'</p>';
            $response['nuevo'] = true;
            $response['total'] = $model->count();
        } else {

            if ($error_nombre){
                $response = crearResponse(
                    'registro_dulicado',
                    false,
                    'Nombre duplicado.',
                    'El nombre o el municipio ya estan registrados.',
                    'warning'
                );
                $response['error_nombre'] = true;
            }

            if ($error_numero){
                $response = crearResponse(
                    'registro_dulicado',
                    false,
                    'Número Duplicado.',
                    'El número ya esta registrado.',
                    'warning'
                );
                $response['error_numero'] = true;
            }

            if ($asignacionMax < $asignacionCargar){
                $response = crearResponse(
                    'registro_dulicado',
                    false,
                    'Revisar la Asignación.',
                    'El nombre ó el municipio ya estan registrados.',
                    'warning'
                );
                $response['error_asignacion'] = true;
                $response['message_asignacion'] = 'La Asignación de las parroquias no debe ser mayor a la del municipio.';
            }else{
                $response['error_asignacion'] = false;
            }

        }

        return $response;
    }

    public function edit($id): array
    {
        $model = new Bloque();
        $bloque = $model->find($id);
        $response = crearResponse(
            null,
            true,
            'Editar Bloque.',
            'Editar Bloque.',
            'success',
            false,
            false
        );
        $response['id'] = $bloque['id'];
        $response['numero'] = $bloque['numero'];
        $response['nombre'] = $bloque['nombre'];
        $response['asignacion'] = $bloque['familias'];
        $response['municipios_id'] = $bloque['municipios_id'];
        return $response;
    }

    public function update($id, $numero, $nombre, $municipios_id, $asignacion): array
    {
        $model = new Bloque();
        $modelMunicipio = new Municipio();
        $cambios = true;
        $bloque = $model->find($id);

        if ($bloque['numero'] != $numero) {
            $cambios = false;
            $model->update($id, 'numero', $numero);
        }

        if ($bloque['nombre'] != $nombre) {
            $cambios = false;
            $model->update($id, 'nombre', $nombre);
        }

        if ($bloque['familias'] != $asignacion) {
            $cambios = false;
            $model->update($id, 'familias', $asignacion);
        }

        if ($bloque['municipios_id'] != $municipios_id) {
            $cambios = false;
            $model->update($id, 'municipios_id', $municipios_id);
        }

        $getMunicipio = $modelMunicipio->find($municipios_id);
        $asignacionMax = $getMunicipio['familias'];
        $getParroquias = $model->getList('municipios_id', '=', $municipios_id);
        $suma = 0;

        foreach ($getParroquias as $getParroquia){
            if ($getParroquia['id'] != $id){
                $suma = $suma + $getParroquia['familias'];
            }
        }

        $asignacionCargar = $suma + $asignacion;

        if (!$cambios && $asignacionMax >= $asignacionCargar) {
            $bloque = $model->find($id);
            $response = crearResponse(
                null,
                true,
                'Bloque Actualizado.',
                'El bloque se ha actualizado exitosamente.'
            );
            $response['id'] = $bloque['id'];
            $response['numero'] = $bloque['numero'];
            $response['nombre'] = $bloque['nombre'];
            $response['asignacion'] = $bloque['familias'];
            $response['total'] = $model->count();
            $response['nuevo'] = false;
            $response['municipios_id'] = $bloque['municipios_id'];
        } else {
            $response = crearResponse('no_cambios');

            if ($asignacionMax < $asignacionCargar){
                $response = crearResponse(
                    'registro_dulicado',
                    false,
                    'Revisar la Asignación.',
                    'El nombre ó el municipio ya estan registrados.',
                    'warning'
                );
                $response['error_asignacion'] = true;
                $response['message_asignacion'] = 'La Asignación de las parroquias no debe ser mayor a la del municipio.';
            }
        }

        return $response;
    }

    public function delete($id): array
    {
        $vinculado = false;
        $modelClap = new Clap();
        $existeClap = $modelClap->existe('bloques_id', '=', $id);

        if ($existeClap){
            $vinculado = true;
            $response = crearResponse('vinculado');
        }else{
            $model = new Bloque();
            $model->delete($id);
            $response = crearResponse(
                null,
                true,
                'Bloque Eliminado.',
                'El bloque se ha eliminado exitosamente.'
            );
        }
        return $response;
    }

}