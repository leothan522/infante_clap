<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\TerritorioController;
$controller = new TerritorioController();

use app\model\Municipio;
use app\model\Parroquia;

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];
        $hoy = date('Y-m-d');

        try {

            $model = new Municipio();

            switch ($opcion) {

                //definimos las opciones a procesar


                case 'paginate_municipio':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';
                    $contenDiv = !empty($_POST['contentDiv']) ? $_POST['contentDiv'] : 'dataContainer';

                    $controller->index('municipios', $limit, $totalRows, $offset);
                    require "../_layout/card_table_municipios.php";

                    break;

                case 'store':

                    if (
                        !empty($_POST['mun_municipio']) &&
                        !empty($_POST['municipio_mini']) &&
                        !empty($_POST['municipio_asignacion'])
                    ) {
                        //proceso
                        $nombre = ucwords($_POST['mun_municipio']);
                        $mini = $_POST['municipio_mini'];
                        $asignacion = $_POST['municipio_asignacion'];
                        $response = $controller->store('municipio', $nombre, $mini, $asignacion);

                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'edit':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->edit('municipio', $id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'editar_municipio':

                    if (
                        !empty($_POST['mun_municipio']) &&
                        !empty($_POST['municipio_mini']) &&
                        !empty($_POST['id'])
                    ) {
                        //proceso
                        $id = $_POST['id'];
                        $nombre = $_POST['mun_municipio'];
                        $mini = $_POST['municipio_mini'];
                        $asignacion = $_POST['municipio_asignacion'];

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
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'eliminar_municipio':

                    if (
                        !empty($_POST['id'])
                    ) {

                        //proceso
                        $id = $_POST['id'];
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

                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'estatus_municipio':

                    if (
                        !empty($_POST['id'])
                    ) {

                        //proceso
                        $id = $_POST['id'];
                        $municipio = $model->find($id);

                        $response = crearResponse(
                            null,
                            true,
                            '',
                            'Municipio Actualizado.'
                        );

                        //datos extras para el $response

                        if ($municipio['estatus']) {
                            $response['title'] = "Municipio Inactivo.";
                            $estatus = 0;
                            $response['icon'] = "info";
                        } else {
                            $response['title'] = "Municipio Activo.";
                            $estatus = 1;
                            $response['icon'] = "success";
                        }
                        $model->update($id, 'estatus', $estatus);

                        $response['estatus'] = $estatus;

                    } else {
                        $response = crearResponse('faltan_datos');
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
