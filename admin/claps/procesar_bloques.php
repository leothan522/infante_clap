<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Bloque;
use app\model\Municipio;
use app\controller\ClapsController;

$controller = new ClapsController();

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {
            $model = new Bloque();
            switch ($opcion) {

                //definimos las opciones a procesar
                case 'guardar_bloque':
                    $modelMunicipio = new Municipio();
                    if (
                        !empty($_POST['bloques_numero']) &&
                        !empty($_POST['municipios_id']) &&
                        !empty($_POST['bloques_asignacion'])
                    ) {
                        //proceso
                        $numero = $_POST['bloques_numero'];
                        $nombre = $_POST['bloques_nombre'];
                        $municipios_id = $_POST['municipios_id'];
                        $asignacion = $_POST['bloques_asignacion'];
                        $bloques = $model->first('municipios_id', '=', $municipios_id);


                        $getBloques = $model->getList('municipios_id', '=', $municipios_id);
                        $existe = false;
                        $error_numero = false;
                        $error_nombre = false;
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


                    } else {
                        //manejo el error
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_bloque':
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $bloque = $model->find($id);
                        $response = crearResponse(
                            null,
                            true,
                            'Editar Bloque.',
                            'Editar Bloque.'
                        );
                        $response['id'] = $bloque['id'];
                        $response['numero'] = $bloque['numero'];
                        $response['nombre'] = $bloque['nombre'];
                        $response['asignacion'] = $bloque['familias'];
                        $response['municipios_id'] = $bloque['municipios_id'];
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'editar_bloque':
                    $modelMunicipio = new Municipio();
                    if (
                        !empty($_POST['bloques_numero']) &&
                        !empty($_POST['bloques_nombre']) &&
                        !empty($_POST['municipios_id']) &&
                        !empty($_POST['municipios_id'])
                    ) {
                        $cambios = true;
                        $numero = $_POST['bloques_numero'];
                        $nombre = $_POST['bloques_nombre'];
                        $asignacion = $_POST['bloques_asignacion'];
                        $municipios_id = $_POST['municipios_id'];
                        $id = $_POST['id'];
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


                    } else {
                        //manejo el error
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'eliminar_bloque':
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];

                        $model->delete($id);
                        $response = crearResponse(
                            null,
                            true,
                            'Bloque Eliminado.',
                            'El bloque se ha eliminado exitosamente.'
                        );

                    } else {
                        //manejo el error
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_municipios':
                    $model = new Municipio();

                    $response = crearResponse(null, true, null, null, 'success', false, true);

                    foreach ($model->getAll() as $municipio) {
                        $id = $municipio['id'];
                        $nombre = $municipio['mini'];
                        if (validarAccesoMunicipio($id)){
                            $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                        }
                    }
                    break;

                case 'get_bloques_municipios':
                    $paginate = true;
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        echo '<div id="dataContainerParroquia">';
                        require_once "_layout/table_bloques.php";
                        echo '</div>';
                    } else {
                        echo '<div id="dataContainerParroquia">';
                        echo '<span>Seleccione un Municipio para empezar</span>';
                        echo '</div>';
                    }
                    break;


                //Por defecto
                default:
                    $response = crearResponse('no_opcion', false, null, $opcion);
                    break;
            }

        } catch (PDOException $e) {
            $response = crearResponse('error_excepcion', false, null, "PDOException {$e->getMessage()}");
        } catch (Exception $e) {
            $response = crearResponse('error_excepcion', false, null, "General Error: {$e->getMessage()}");
        }
    } else {
        $response = crearResponse('error_opcion');
    }
} else {
    $response = crearResponse('error_method');
}

if (!$paginate) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
