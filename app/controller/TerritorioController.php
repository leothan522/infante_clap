<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Bloque;
use app\model\Clap;
use app\model\Cuota;
use app\model\Municipio;
use app\model\Parroquia;
use app\model\User;

class TerritorioController extends Admin
{
    public string $TITTLE = 'Territorio';
    public string $MODULO = 'territorio.index';

    public $links;
    public $rows;
    public $limit;
    public $totalRows;
    public $offset;
    public $keyword;
    public $verMuncipio;

    public function isAdmin()
    {
        parent::isAdmin(); // TODO: Change the autogenerated stub
        if (!validarPermisos($this->MODULO)) {
            header('location: ' . ROOT_PATH . 'admin\\');
        }
    }

    public function index(
        $table = 'municipios',
        $limit = null,
        $totalRows = null,
        $offset = null,
    )
    {
        if ($table == 'municipios') {
            $baseURL = '_request/MunicipiosRequest.php';
            $tableID = 'tabla_municipios';
            $opcion = 'paginate_municipio';
            $contentDiv = 'dataContainerMunicipio';
            $model = new Municipio();
        }else{
            $baseURL = '_request/ParroquiasRequest.php';
            $tableID = 'tabla_parroquias';
            $opcion = 'paginate_parroquias';
            $contentDiv = 'dataContainerParroquia';
            $model = new Parroquia();
        }


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

        $this->links = paginate($baseURL, $tableID, $this->limit, $this->totalRows, $this->offset, $opcion, $contentDiv)->createLinks();
        $this->rows = $model->paginate($this->limit, $this->offset);
    }

    public function store($table, $nombre, $mini, $asignacion, $municipio = null): array
    {
        $hoy = date('Y-m-d');

        if ($table == "municipio"){
            $model = new Municipio();

            $existeMunicipio = $model->existe('nombre', '=', $nombre, null);
            $existeMini = $model->existe('mini', '=', $mini, null);

            if (!$existeMunicipio && !$existeMini) {

                $data = [
                    $nombre,
                    $mini,
                    $asignacion,
                    $hoy
                ];

                $model->save($data);
                $municipios = $model->first('nombre', '=', $nombre);
                $response = crearResponse(
                    null,
                    true,
                    'Municipio Creado Exitosamente.',
                    "Municipio Creado " . $nombre
                );
                //datos extras para el $response
                $response['id'] = $municipios['id'];
                $response['item'] = '<p> ' . $model->count() . '. </p>';
                $response['nombre'] = '<p class="text-uppercase">'.$municipios['nombre'].'</p>';
                $response['mini'] = '<p class="text-uppercase">'.$municipios['mini'].'</p>';
                $response['asignacion'] = '<p class="text-right">'.formatoMillares($municipios['familias'], 0).'</p>';
                $response['parroquias'] = formatoMillares($municipios['parroquias'], 0);
                $response['nuevo'] = true;
                $response['total'] = $model->count();
                $response['btn_editar'] = validarPermisos('municipios.edit');
                $response['btn_eliminar'] = validarPermisos('municipios.destroy');
                $response['btn_estatus'] = validarPermisos('municipios.estatus');

            } else {

                $response = crearResponse(
                    'nombre_duplicado',
                    false,
                    'Nombre Duplicado.',
                    'El nombre ya esta registrado.',
                    'warning'
                );

                //datos extras para el $response

                if ($existeMunicipio) {
                    $response['error_municipio'] = true;
                    $response['message_municipio'] = 'El nombre ya esta registrado.';
                } else {
                    $response['error_municipio'] = false;
                }

                if ($existeMini) {
                    $response['error_mini'] = true;
                    $response['message_mini'] = 'La abreviatura ya esta registrada.';
                } else {
                    $response['error_mini'] = false;
                }

            }


        }else{
            $model = new Parroquia();
            $modelMunicipio = new Municipio();
            if (empty($asignacion)) {
                if ($asignacion != 0) {
                    $asignacion = null;
                }
                $asignacion_sql = "";
            } else {
                $asignacion_sql = "AND `familias` = '$asignacion'";
            }

            $existeNombre = $model->existe('nombre', '=', $nombre, null);
            $existeMini = $model->existe('mini', '=', $mini, null);

            $getMunicipio = $modelMunicipio->find($municipio);
            $asignacionMax = $getMunicipio['familias'];
            $getParroquias = $model->getList('municipios_id', '=', $municipio);
            $suma = 0;

            foreach ($getParroquias as $getParroquia){
                $suma = $suma + $getParroquia['familias'];
            }

            $asignacionCargar = $suma + $asignacion;

            if (!$existeNombre && !$existeMini && $asignacionMax >= $asignacionCargar) {
                //se guarda
                $data = [
                    $nombre,
                    $mini,
                    $municipio,
                    $asignacion,
                    $hoy
                ];

                $model->save($data);
                $parroquias = $model->existe('nombre', '=', $nombre, null);
                $municipio = $modelMunicipio->find($parroquias['municipios_id']);

                //incremento contador de parroquis al municipio
                $count = $municipio['parroquias'] + 1;
                $modelMunicipio->update($municipio['id'], 'parroquias', $count);

                $response = crearResponse(
                    null,
                    true,
                    'Parroquia Creada Exitosamente.',
                    "Parroquia Creado exitosamente" . $nombre
                );
                //datos extras para el $response
                $response['id'] = $parroquias['id'];
                $response['item'] = '<p class="text-center">' . $model->count() . '.</p>';
                $response['municipio'] ='<p class="text-center text-uppercase">'.$municipio['mini'].'</p>';
                $response['municipios_id'] = $municipio['id'];
                $response['municipio_parroquias'] = $count;
                $response['parroquia'] = '<p class="text-uppercase">'.$parroquias['nombre'].'</p>';
                $response['mini'] = '<p class="text-center text-uppercase">'.$parroquias['mini'].'</p>';
                $response['asignacion'] = '<p class="text-right">'.formatoMillares($parroquias['familias'], 0).'</p>';
                $response['nuevo'] = true;
                $response['total'] = $model->count();
                $response['btn_editar'] = validarPermisos('parroquias.edit');
                $response['btn_eliminar'] = validarPermisos('parroquias.destroy');
                $response['btn_estatus'] = validarPermisos('parroquias.estatus');

            } else {
                //la parroquia ya existe

                //datos extras para el $response

                if ($existeNombre) {
                    $response = crearResponse(
                        'nombre_duplicado',
                        false,
                        'Nombre Duplicado.',
                        'La parroquia ya esta registrada.',
                        'warning'
                    );
                    $response['error_nombre'] = true;
                    $response['message_nombre'] = 'El nombre de la parroquia ya esta registrado.';
                } else {
                    $response['error_nombre'] = false;
                }

                if ($existeMini) {
                    $response = crearResponse(
                        'nombre_duplicado',
                        false,
                        'Abreviatura Duplicada.',
                        'La parroquia ya esta registrada.',
                        'warning'
                    );
                    $response['error_mini'] = true;
                    $response['message_mini'] = 'La abreviatura ya esta registrada.';
                } else {
                    $response['error_mini'] = false;
                }

                if ($asignacionMax < $asignacionCargar){
                    $response = crearResponse(
                        'nombre_duplicado',
                        false,
                        'Revisar Asignacion.',
                        'La parroquia ya esta registrada.',
                        'warning'
                    );
                    $response['error_asignacion'] = true;
                    $response['message_asignacion'] = 'La Asignación de las parroquias no debe ser mayor a la del municipio.';
                }else{
                    $response['error_asignacion'] = false;
                }

            }

        }

        return $response;
    }

    public function edit($table, $id): array
    {
        if ($table == "municipio"){
            $model = new Municipio();
            $municipio = $model->find($id);
            $response = crearResponse(
                null,
                true,
                'Editar Muncipio.',
                "Municipio " . $municipio['nombre'],
                'success',
                false,
                true
            );
            //datos extras para el $response
            $response['id'] = $municipio['id'];
            $response['nombre'] = $municipio['nombre'];
            $response['mini'] = $municipio['mini'];
            $response['asignacion'] = $municipio['familias'];
        }else{
            $model = new Parroquia();
            $parroquia = $model->find($id);
            $response = crearResponse(
                null,
                true,
                'Editar Parroquia.',
                "parroquia " . $parroquia['nombre'],
                'success',
                false,
                true
            );
            //datos extras para el $response
            $response['id'] = $parroquia['id'];
            $response['municipios'] = $parroquia['municipios_id'];
            $response['parroquia'] = $parroquia['nombre'];
            $response['mini'] = $parroquia['mini'];
            $response['asignacion'] = $parroquia['familias'];
        }

        return $response;
    }

    public function update($table, $id, $nombre, $mini, $asignacion, $municipio = null): array
    {
        $hoy = date('Y-m-d');

        if ($table == 'municipios'){

            $model = new Municipio();
            $existeMunicipio = $model->existe('nombre', '=', $nombre, $id);
            $existeMini = $model->existe('mini', '=', $mini, $id);

            if (!$existeMunicipio && !$existeMini) {

                $municipio = $model->find($id);
                $db_nombre = $municipio['nombre'];
                $db_mini = $municipio['mini'];
                $db_asignacion = $municipio['familias'];
                $cambios = false;

                if ($db_nombre != $nombre) {
                    $cambios = true;
                    $model->update($id, 'nombre', $nombre);
                    $model->update($id, 'updated_at', $hoy);
                }

                if ($db_mini != $mini) {
                    $cambios = true;
                    $model->update($id, 'mini', $mini);
                    $model->update($id, 'updated_at', $hoy);
                }

                if ($db_asignacion != $asignacion) {
                    $cambios = true;
                    $model->update($id, 'familias', $asignacion);
                    $model->update($id, 'updated_at', $hoy);
                }

                if ($cambios) {
                    $response = crearResponse(
                        null,
                        true,
                        'Municipio Actualizado.',
                        "Municipio Creado " . $nombre
                    );

                    //datos extras para el $response

                    $response['id'] = $id;
                    $response['nombre'] = $nombre;
                    $response['mini'] = $mini;
                    $response['asignacion'] = '<p class="text-right">'.formatoMillares($asignacion, 0).'</p>';
                    $response['total'] = $model->count();
                    $response['nuevo'] = false;

                    //busco las parroquias vinculadas al municipio
                    $modelParroquia = new Parroquia();
                    $response['parroquias'] = array();
                    foreach ($modelParroquia->getList('municipios_id', '=', $id) as $parroquia) {
                        $response['parroquias'][] = array('id' => $parroquia['id']);
                    }

                } else {
                    $response = crearResponse('no_cambios');
                }

            } else {

                $response = crearResponse(
                    'nombre_duplicado',
                    false,
                    'Nombre Duplicado.',
                    'El nombre ya esta registrado.',
                    'warning'
                );

                //datos extras para el $response

                if ($existeMunicipio) {
                    $response['error_municipio'] = true;
                    $response['message_municipio'] = 'El nombre ya esta registrado.';
                } else {
                    $response['error_municipio'] = false;
                }

                if ($existeMini) {
                    $response['error_mini'] = true;
                    $response['message_mini'] = 'La abreviatura ya esta registrada.';
                } else {
                    $response['error_mini'] = false;
                }

            }

        }else{
            $model = new Parroquia();
            $modelMunicipio = new Municipio();
            $procesar = false;
            $existeParroquia = $model->existe('nombre', '=', $nombre, $id);
            $existeMini = $model->existe('mini', '=', $mini, $id);

            $getMunicipio = $modelMunicipio->find($municipio);
            $asignacionMax = $getMunicipio['familias'];

            $getParroquias = $model->getList('municipios_id','=', $municipio);
            $suma = 0;
            foreach ($getParroquias as $getParroquia){
                if ($getParroquia['id'] != $id){
                    $suma = $suma + $getParroquia['familias'];
                }
            }

            $asignacionCargar = $suma + $asignacion;

            $response = crearResponse(
                null,
                true,
                'Parroquia Actualizada.',
                'Parroquia editada exitosamente'
            );

            if (!$existeParroquia && !$existeMini && $asignacionMax >= $asignacionCargar) {
                $parroquias = $model->find($id);
                $db_municipio = $parroquias['municipios_id'];
                $db_parroquia = $parroquias['nombre'];
                $db_mini = $parroquias['mini'];
                $db_asignacion = $parroquias['familias'];
                $response['edit_municipio'] = false;

                if ($db_municipio != $municipio) {
                    $procesar = true;
                    $model->update($id, 'municipios_id', $municipio);
                    $model->update($id, 'updated_at', $hoy);
                    $municipio_anterior = $modelMunicipio->find($db_municipio);
                    $restar = $municipio_anterior['parroquias'] - 1;
                    $modelMunicipio->update($municipio_anterior['id'], 'parroquias', $restar);
                    $municipio_actual = $modelMunicipio->find($municipio);
                    $sumar = $municipio_actual['parroquias'] + 1;
                    $modelMunicipio->update($municipio_actual['id'], 'parroquias', $sumar);
                    $response['anterior_id'] = $municipio_anterior['id'];
                    $response['anterior_cantidad'] = $restar;
                    $response['actual_id'] = $municipio_actual['id'];
                    $response['actual_cantidad'] = $sumar;
                    $response['edit_municipio'] = true;
                }

                if ($db_parroquia != $nombre) {
                    $procesar = true;
                    $model->update($id, 'nombre', $nombre);
                    $model->update($id, 'updated_at', $hoy);
                }

                if ($db_mini != $mini) {
                    $procesar = true;
                    $model->update($id, 'mini', $mini);
                    $model->update($id, 'updated_at', $hoy);
                }

                if ($db_asignacion != $asignacion) {
                    $procesar = true;
                    $model->update($id, 'familias', $asignacion);
                    $model->update($id, 'updated_at', $hoy);
                }

                if ($procesar) {
                    $parroquias = $model->find($id);
                    $municipio = $modelMunicipio->find($parroquias['municipios_id']);
                    $response['id'] = $id;
                    $response['municipio'] = '<p class="text-uppercase">'.$municipio['mini'].'</p>';
                    $response['parroquia'] = '<p class="text-uppercase">'.$nombre.'</p>';
                    $response['total'] = $model->count();
                    $response['mini'] = '<p class="text-center text-uppercase">'.$parroquias['mini'].'</p>';
                    $response['asignacion'] = '<p class="text-right">'.formatoMillares($parroquias['familias'], 0).'</p>';
                    $response['nuevo'] = false;
                } else {
                    $response = crearResponse('no_cambios');
                }

            } else {

                $response = crearResponse(
                    'nombre_duplicado',
                    false,
                    'Parroquia ya Registrada.',
                    'La parroquia ya esta registrada.',
                    'warning'
                );

                //datos extras para el $response

                if ($existeParroquia) {
                    $response['error_nombre'] = true;
                    $response['message_nombre'] = 'El nombre de la parroquia ya esta registrado.';
                } else {
                    $response['error_nombre'] = false;
                }

                if ($existeMini) {
                    $response['error_mini'] = true;
                    $response['message_mini'] = 'La abreviatura ya esta registrada.';
                } else {
                    $response['error_mini'] = false;
                }

                if ($asignacionMax < $asignacionCargar){
                    $response['error_asignacion'] = true;
                    $response['message_asignacion'] = 'La Asignación de las parroquias no debe ser mayor a la del municipio.';
                }else{
                    $response['error_asignacion'] = false;
                }

            }


        }

        return $response;

    }

    public function delete($table, $id): array
    {
        $vinculado = false;
        $modelBloque = new Bloque();
        $modalClap = new Clap();
        $modalCuota = new Cuota();

        $existeBloque = $modelBloque->existe('municipios_id', "=", $id);
        $existeClap = $modalClap->existe('municipios_id', '=', $id);
        $existeCuota = $modalCuota->existe('municipios_id', '=', $id);
        
        if ($existeBloque || $existeClap || $existeCuota){
            $vinculado = true;
            $response = crearResponse('vinculado');
        }else{
            if ($table == 'municipios'){
                $model = new Municipio();
                $response = crearResponse(
                    null,
                    true,
                    'Municipio Eliminado.',
                    'Municipio Eliminado.'
                );

                //chequeo las parroquias vinculadas a ese municipio
                $modelParroquia = new Parroquia();
                $response['parroquias'] = array();
                foreach ($modelParroquia->getList('municipios_id', '=', $id) as $parroquia) {
                    $response['parroquias'][] = array("id" => $parroquia['id']);
                }
                $model->delete($id);

                //datos extras para el $response
                $response['total'] = $model->count();
                $response['total_parroquias'] = $modelParroquia->count();

            }else{
                $model = new Parroquia();
                //resto al contador de parroquias
                $parroquia = $model->find($id);
                $modelMunicipio = new Municipio();
                $municipio = $modelMunicipio->find($parroquia['municipios_id']);
                $count = $municipio['parroquias'] - 1;
                $modelMunicipio->update($municipio['id'], 'parroquias', $count);
                $model->delete($id);

                $response = crearResponse(
                    null,
                    true,
                    'Parroquia Eliminada.',
                    'Parroquia Eliminada Exitosamente.'
                );

                //datos extras para el $response
                $response['total'] = $model->count();
                $response['municipios_id'] = $municipio['id'];
                $response['municipio_parroquias'] = $count;

            }
        }

        return $response;
    }

    public function setEstatus($table, $id): array
    {
        if ($table == 'municipios'){
            $model = new Municipio();
            $label = "Municipio";
        }else{
            $model = new Parroquia();
            $label = "Parroquia";
        }
        $territorio = $model->find($id);
        $response = crearResponse(
            null,
            true,
            '',
            'Estatus Actualizado.'
        );

        //datos extras para el $response
        if ($territorio['estatus']) {
            $response['title'] = "$label Inactivo.";
            $estatus = 0;
            $response['icon'] = "info";
        } else {
            $response['title'] = "$label Activo.";
            $estatus = 1;
            $response['icon'] = "success";
        }
        $model->update($id, 'estatus', $estatus);

        $response['estatus'] = $estatus;

        if ($table == 'municipios'){
            $response['btn_editar'] = validarPermisos('municipios.edit');
            $response['btn_eliminar'] = validarPermisos('municipios.destroy');
            $response['btn_estatus'] = validarPermisos('municipios.estatus');
        }else{
            $response['btn_editar'] = validarPermisos('parroquias.edit');
            $response['btn_eliminar'] = validarPermisos('parroquias.destroy');
            $response['btn_estatus'] = validarPermisos('parroquias.estatus');
        }

        return $response;
    }

    public function getMunicipios(): array
    {
        $model = new Municipio();
        $response = crearResponse(
            null,
            true,
            null,
            null,
            'success',
            false,
            true
        );
        $response['municipios'] = array();
        foreach ($model->getAll() as $municipio) {
            $id = $municipio['id'];
            $nombre = $municipio['nombre'];
            $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
        }
        return $response;
    }

    public function getParroquias($id)
    {
        $model = new Parroquia();
        $modelMunicipio = new Municipio();
        $municipio = $modelMunicipio->find($id);
        $this->verMuncipio = $municipio['nombre'];
        $this->rows = $model->getList('municipios_id', '=', $id);
    }

    public function getMunicipio($id): mixed
    {
        $model = new Municipio();
        $municipio = $model->find($id);
        return $municipio['mini'];

    }

    public function countParroquias($id): mixed
    {
        $model = new Parroquia();
        return $model->count(null, 'municipios_id', '=', $id);
    }

    public function search($keyword, $table){
        $model = new User();
        $this->keyword = $keyword;
        if ($table == 'municipios'){
            $sql = "SELECT * FROM municipios WHERE nombre LIKE '%$keyword%' OR mini LIKE '%$keyword%' OR parroquias LIKE '%$keyword%' OR familias LIKE '%$keyword%';";
            $this->rows = $model->sqlPersonalizado($sql, 'getAll');
        }
        if ($table == 'parroquias'){
            $sql = "SELECT * FROM parroquias WHERE nombre LIKE '%$keyword%' OR mini LIKE '%$keyword%' OR municipios_id LIKE '%$keyword%' OR familias LIKE '%$keyword%';";
            $this->rows = $model->sqlPersonalizado($sql, 'getAll');
        }
    }

}