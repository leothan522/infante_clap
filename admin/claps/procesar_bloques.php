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
                    if (
                        !empty($_POST['bloques_numero']) &&
                        !empty($_POST['bloques_nombre']) &&
                        !empty($_POST['municipios_id'])
                    ) {
                        //proceso
                        $numero = $_POST['bloques_numero'];
                        $nombre = $_POST['bloques_nombre'];
                        $municipios_id = $_POST['municipios_id'];
                        $bloques = $model->first('municipios_id', '=', $municipios_id);


                        $getBloques = $model->getList('municipios_id', '=', $municipios_id);
                        $existe = false;
                        $error_numero = false;
                        $error_nombre = false;
                        foreach ($getBloques as $bloque) {
                            $db_nombre = $bloque['nombre'];
                            $db_numero = $bloque['numero'];
                            if ($db_nombre == $nombre) {
                                $existe = true;
                                $error_nombre = true;
                            }
                            if ($db_numero == $numero) {
                                $existe = true;
                                $error_numero = true;
                            }
                        }

                        if (!$existe) {
                            $data = [
                                $numero,
                                $nombre,
                                $municipios_id
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
                            $response['nombre'] = $bloque['nombre'];
                            $response['municipios_id'] = $bloque['municipios_id'];
                            $response['nuevo'] = true;
                            $response['total'] = $model->count();
                        } else {
                            $response = crearResponse(
                                'registro_dulicado',
                                false,
                                'Registro Duplicado.',
                                'El nombre ó el municipio ya estan registrados.',
                                'warning',
                                true
                            );
                            $response['error_nombre'] = $error_nombre;
                            $response['error_numero'] = $error_numero;
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
                        $response['municipios_id'] = $bloque['municipios_id'];
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'editar_bloque':
                    if (
                        !empty($_POST['bloques_numero']) &&
                        !empty($_POST['bloques_nombre']) &&
                        !empty($_POST['municipios_id'])
                    ) {
                        $cambios = true;
                        $numero = $_POST['bloques_numero'];
                        $nombre = $_POST['bloques_nombre'];
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

                        if ($bloque['municipios_id'] != $municipios_id) {
                            $cambios = false;
                            $model->update($id, 'municipios_id', $municipios_id);
                        }

                        if (!$cambios) {
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
                            $response['total'] = $model->count();
                            $response['nuevo'] = false;
                            $response['municipios_id'] = $bloque['municipios_id'];
                        } else {
                            $response = crearResponse('no_cambios');
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
                        $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
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
