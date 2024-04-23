<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Parametros;
use app\model\User;

class RolesController extends Admin
{
    public $rows;
    public $totalRows;

    public function index()
    {
        $model = new Parametros();
        $this->rows = $model->getList('tabla_id', '=', -1);
        $this->totalRows = $model->count(null, 'tabla_id', '=', -1);
    }

    public function store($nombre): array
    {
        $model = new Parametros();

        if ($model->count(null, 'tabla_id', '=', '-1') >= 10){
            $response = crearResponse(
                'max_alcanzado',
                false,
                'No se pueden crear mas Roles.',
                null,
                'warning'
            );
            return $response;
        }

        if (mb_strlen($nombre) < 4){
            $response = crearResponse(
                'no_minimo',
                false,
                'El Nombre debe tener al menos 4 caracteres.',
                null,
                'warning'
            );
            return $response;
        }

        $existe = $model->existe('nombre', '=', $nombre);

        if (!$existe){
            $data = [
                $nombre,
                -1,
                null
            ];
            $model->save($data);
            $rol = $model->first('nombre', '=', $nombre);
            $response = crearResponse(
                null,
                true,
                'Rol Creado.'
            );
            $response['id'] = $rol['id'];
            $response['nombre'] = ucfirst($rol['nombre']);
            $response['rows'] = $model->count(null, 'tabla_id', '=', -1);
            foreach ($model->getList('tabla_id', '=', -1) as $rol) {
                $id = $rol['id'];
                $nombre = ucfirst($rol['nombre']);
                $response['roles'][] = array("id" => $id, "nombre" => $nombre);
            }
        }else{
            $response = crearResponse(
                'nombre_duplicado',
                false,
                'El Rol ya Existe.',
                null,
                'error'
            );
        }
        return $response;
    }

    public function edit($id): array
    {
        $model = new Parametros();
        $rol = $model->find($id);
        $response = crearResponse(
            null,
            true,
            'Editar Rol.',
            null,
            'success',
            false,
            true
        );
        $response['id'] = $rol['id'];
        $response['nombre'] = ucfirst($rol['nombre']);
        $response['permisos'] = $rol['valor'];
        if (!is_null($response['permisos'])) {
            $response['user_permisos'] = json_decode($response['permisos']);
        } else {
            $response['user_permisos'] = null;
        }
        $permisos = verPermisos('_role');
        $response['permisos'] = $permisos[1];
        $response['html_permisos'] = $permisos[0];
        foreach ($model->getList('tabla_id', '=', -1) as $rol) {
            $id = $rol['id'];
            $nombre = ucfirst($rol['nombre']);
            $response['roles'][] = array("id" => $id, "nombre" => $nombre);
        }
        return $response;
    }

    public function update($id, $nombre, $permisos): array
    {
        $model = new Parametros();

        $existe = $model->existe('nombre', '=', $nombre, $id);

        if (!$existe){
            if (mb_strlen($nombre) < 4){
                $response = crearResponse(
                    'no_minimo',
                    false,
                    'El Nombre debe tener al menos 4 caracteres.',
                    null,
                    'warning'
                );
                return $response;
            }

            $model->update($id, 'nombre', $nombre);
            $model->update($id, 'valor', crearJson($permisos));
            $response = $this->edit($id);
            $response['toast'] = false;
            $response['title'] = 'Cambios Guardados.';

            $model = new User();
            $listarUsuarios = $model->getList('role_id', '=', $id);
            if ($listarUsuarios){
                foreach ($listarUsuarios as $user){
                    $model->update($user['id'], 'permisos', crearJson($permisos));
                }
            }
        }else{
            $response = crearResponse(
                'nombre_duplicado',
                false,
                'El Rol ya Existe.',
                null,
                'error'
            );
        }
        return $response;
    }

    public function delete($id): array
    {
        $model = new User();
        $vinculado = $model->existe('role_id', '=', $id);
        if ($vinculado){
            $response = crearResponse('vinculado');
        }else{
            $model = new Parametros();
            $model->delete($id);
            $response = crearResponse(
                null,
                true,
                'Rol Eliminado.'
            );
            $response['id'] = $id;
            $response['rows'] = $model->count(null, 'tabla_id', '=', -1);
            $roles = $model->getList('tabla_id', '=', -1);
            if ($roles){
                foreach ($roles as $rol) {
                    $id = $rol['id'];
                    $nombre = $rol['nombre'];
                    $response['roles'][] = array("id" => $id, "nombre" => $nombre);
                }
            }else{
                $response['roles'] = array();
            }


        }
        return $response;
    }

}