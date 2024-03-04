<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\TerritorioController;
$controller  = new TerritorioController();

use app\model\Parroquia;
use app\model\Municipio;

$response = array();
$paginate = false;
$controller = new TerritorioController();

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];
        $hoy = date('Y-m-d');

        try {

            $model = new Parroquia();

            switch ($opcion) {

                //definimos las opciones a procesar

                case 'paginate_parroquias':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';
                    $contenDiv = !empty($_POST['contentDiv']) ? $_POST['contentDiv'] : 'dataContainer';

                    $controller->index('parroquia', $limit, $totalRows, $offset);
                    require "../_layout/card_table_parroquias.php";

                    break;

                case 'store':

                    $modelMunicipio = new Municipio();

                    if (
                        !empty($_POST['parroquia_municipio']) &&
                        !empty($_POST['parroquia_nombre']) &&
                        !empty($_POST['parroquia_mini'])
                    ) {
                        //declaramos en variables lo que resivimos por el metodo post
                        $municipio = $_POST['parroquia_municipio'];
                        $nombre = ucwords($_POST['parroquia_nombre']);
                        $mini = $_POST['parroquia_mini'];
                        $asignacion = $_POST['parroquia_asignacion'];
                        $response = $controller->store('parroquia', $nombre, $mini, $asignacion, $municipio);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'edit':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = $controller->edit('parroquia', $id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'editar_parroquia':

                    $modelMunicipio = new Municipio();
                    if (
                        !empty($_POST['parroquia_municipio']) &&
                        !empty($_POST['parroquia_nombre']) &&
                        !empty($_POST['id']) &&
                        !empty($_POST['parroquia_mini']) &&
                        !empty($_POST['parroquia_asignacion'])
                    ) {
                        $municipio = $_POST['parroquia_municipio'];
                        $parroquia_nombre = $_POST['parroquia_nombre'];
                        $id = $_POST['id'];
                        $mini = $_POST['parroquia_mini'];
                        $asignacion = $_POST['parroquia_asignacion'];
                        $procesar = false;

                        $existeParroquia = $model->existe('nombre', '=', $parroquia_nombre, $id);
                        $existeMini = $model->existe('nombre', '=', $parroquia_nombre, $id);

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

                            if ($db_parroquia != $parroquia_nombre) {
                                $procesar = true;
                                $model->update($id, 'nombre', $parroquia_nombre);
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
                                $response['municipio'] = '<p class="text-uppercase">'.$municipio['nombre'].'</p>';
                                $response['parroquia'] = '<p class="text-uppercase">'.$parroquia_nombre.'</p>';
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

                    } else {
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'eliminar_parroquia':

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
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

                    } else {
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_municipios_select':

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

                    break;

                case 'filtrar_parroquias':
                    $paginate = true;
                    $model = new Parroquia();
                    $limit = 100;
                    if (!empty($_POST['id'])){
                        $cantidadParroquias = count($model->getList('municipios_id', '=', $_POST['id']));
                        $listarParroquias = $model->paginate($limit, null, 'nombre', 'ASC', null, 'municipios_id', '=', $_POST['id']);
                        $links = paginate('ParroquiasRequest.php', 'tabla_parroquias', $limit, $cantidadParroquias, null, 'paginate_parroquia', 'dataContainerParroquia', '_parroquia')->createLinks();
                    }else{
                        if (numRowsPaginate() < 15){$paginate = 15; }else{ $paginate = numRowsPaginate(); }
                        $limit = $paginate;
                        $links = paginate('ParroquiasRequest.php', 'tabla_parroquias', $limit, $model->count(), null, 'paginate_parroquia', 'dataContainerParroquia','_parroquia')->createLinks();
                        $listarParroquias = $model->paginate($limit, null, 'nombre', 'ASC');
                    }

                    $i = 0;
                    echo '<div id="dataContainerParroquia">';
                    require_once "../_layout/card_table_parroquias.php";
                    echo '</div>';

                    break;

                case 'estatus_parroquia':
                    $model = new Parroquia();
                    if(
                        !empty($_POST['id'])
                    ) {

                        //proceso
                        $id = $_POST['id'];
                        $parroquia = $model->find($id);

                        $response = crearResponse(
                            null,
                            true,
                            '',
                            'Estatus de parroquia.'
                        );

                        //datos extras para el $response

                        if ($parroquia['estatus']){
                            $response['title'] = "parroquia Inactiva.";
                            $estatus = 0;
                            $response['icon'] = "info";
                        }else{
                            $response['title'] = "parroquia Activa.";
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

