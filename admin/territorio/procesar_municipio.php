<?php
session_start();
require_once "../../vendor/autoload.php";

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

                    $listarMunicipios = $model->paginate($limit, $offset, 'nombre', 'DESC',);
                    $links = paginate($baseURL, $tableID, $limit, $model->count(), $offset, $opcion, 'dataContainerMunicipio', '_municipio')->createLinks();
                    $i = $offset;
                    echo '<div id="dataContainerMunicipio">';
                    require_once "_layout/card_table_municipios.php";
                    echo '</div>';

                    break;

                case 'guardar_municipio':

                    if (!empty($_POST['mun_municipio']) && !empty($_POST['municipio_mini'])) {
                        //proceso
                        $nombre = ucwords($_POST['mun_municipio']);
                        $mini = $_POST['municipio_mini'];
                        $asignacion = $_POST['municipio_asignacion'];

                        if (empty($asignacion)) {
                            if ($asignacion != 0) {
                                $asignacion = null;
                            }
                            $asignacion_sql = "";
                        } else {
                            $asignacion_sql = "AND `familias` = '$asignacion'";
                        }


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
                            $response['nombre'] = $municipios['nombre'];
                            $response['mini'] = $municipios['mini'];
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
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'get_municipio':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
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
