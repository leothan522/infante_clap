<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Parroquia;
use app\model\Municipio;
use app\controller\TerritorioController;

$response = array();
$paginate = false;
$controller = new TerritorioController();

if ($_POST) {

    try {
        if (!empty($_POST['opcion'])) {
            $opcion = $_POST['opcion'];


            switch ($opcion) {

                //definimos las opciones a procesar

                case 'paginate_parroquia':
                    $paginate = true;
                    $model = new Parroquia();

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';

                    $listarParroquias = $model->paginate($limit, $offset, 'nombre', 'ASC', 1);
                    $links = paginate($baseURL, $tableID, $limit, $model->count(1), $offset, $opcion, 'dataContainerParroquia', '_parroquia')->createLinks();
                    $i = $offset;
                    echo '<div id="dataContainerParroquia">';
                    require_once "_layout/card_table_parroquias.php";
                    echo '</div>';
                    break;

                case 'guardar_parroquia':
                    $model = new Parroquia();
                    $modelMunicipio = new Municipio();

                    if (
                        !empty($_POST['parroquia_municipio']) &&
                        !empty($_POST['parroquia_nombre'])
                    ) {
                        //declaramos en variables lo que resivimos por el metodo post
                        $municipio = $_POST['parroquia_municipio'];
                        $parroquia = ucwords($_POST['parroquia_nombre']);

                        $existe = $model->existe('nombre', '=', $parroquia, null, 1);

                        if (!$existe) {
                            //se guarda
                            $data = [
                                $municipio,
                                $parroquia
                            ];

                            $model->save($data);
                            $parroquias = $model->existe('nombre', '=', $parroquia, null, 1);
                            $municipio = $modelMunicipio->find($parroquias['municipios_id']);

                            //incremento contador de parroquis al municipio
                            $count = $municipio['parroquias'] + 1;
                            $modelMunicipio->update($municipio['id'], 'parroquias', $count);

                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = false;
                            $response['icon'] = "success";
                            $response['title'] = "Parroquia Creada Exitosamente.";
                            $response['message'] = "Parroquia Creado exitosamente" . $parroquia;
                            $response['id'] = $parroquias['id'];
                            $response['item'] = '<p class="text-center">'.$model->count(1).'.</p>';
                            $response['municipio'] = $municipio['nombre'];
                            $response['municipios_id'] = $municipio['id'];
                            $response['municipio_parroquias'] = $count;
                            $response['parroquia'] = $parroquias['nombre'];
                            $response['nuevo'] = true;
                            $response['total'] = $model->count(1);



                        } else {
                            //la parroquia ya existe
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = "nombre_duplicado";
                            $response['icon'] = "warning";
                            $response['title'] = "Parroquia Duplicada.";
                            $response['message'] = "La parroquia ya esta registrada.";
                        }


                    } else {
                        //no fue enviado por el metodo post
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan datos.";
                        $response['message'] = "Deben enviarse los datos por el metodo post";
                    }

                    break;

                case 'get_parroquia':
                    $model = new Parroquia();
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $parroquia = $model->find($id);
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = false;
                        $response['icon'] = "success";
                        $response['title'] = "Editar Parroquia.";
                        $response['message'] = "parroquia " . $parroquia['nombre'];
                        $response['id'] = $parroquia['id'];
                        $response['municipios'] = $parroquia['municipios_id'];
                        $response['parroquia'] = $parroquia['nombre'];

                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan Datos.";
                        $response['message'] = "Todos los datos son requeridos.";
                    }
                    break;

                case 'editar_parroquia':
                    $model = new Parroquia();
                    $modelMunicipio = new Municipio();
                    if (
                        !empty($_POST['parroquia_municipio']) &&
                        !empty($_POST['parroquia_nombre']) &&
                        !empty($_POST['id'])
                    ) {
                        $municipio = $_POST['parroquia_municipio'];
                        $parroquia_nombre = ucwords($_POST['parroquia_nombre']);
                        $id = $_POST['id'];
                        $procesar = false;
                        $existe_parroquia = $model->existe('nombre', '=', $parroquia_nombre, $id, 1);

                        if (!$existe_parroquia){
                            $parroquias = $model->find($id);
                            $db_municipio = $parroquias['municipios_id'];
                            $db_parroquia = $parroquias['nombre'];
                            $response['edit_municipio'] = false;

                            if ($db_municipio != $municipio){
                                $procesar = true;
                                $model->update($id, 'municipios_id', $municipio);
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

                            if ($db_parroquia != $parroquia_nombre){
                                $procesar = true;
                                $model->update($id, 'nombre', $parroquia_nombre);
                            }

                            if ($procesar){
                                $parroquias = $model->find($id);
                                $municipio = $modelMunicipio->find($parroquias['municipios_id']);
                                $response['result'] = true;
                                $response['alerta'] = false;
                                $response['error'] = false;
                                $response['icon'] = "success";
                                $response['title'] = "Parroquia Actualizada.";
                                $response['message'] = "Parroquia editada exitosamente";
                                $response['id'] = $id;
                                $response['municipio'] = $municipio['nombre'];
                                $response['parroquia'] = $parroquia_nombre;
                                $response['total'] = $model->count(1);
                                $response['nuevo'] = false;
                            } else {
                                $response['result'] = false;
                                $response['alerta'] = true;
                                $response['error'] = "no_cambios";
                                $response['icon'] = "warning";
                                $response['title'] = "Sin Cambios.";
                                $response['message'] = "No se realizaron Cambios.";
                            }

                        }else {
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = "nombre_duplicado";
                            $response['icon'] = "warning";
                            $response['title'] = "Parroquia ya Registrada.";
                            $response['message'] = "La parroquia ya ha sido registrada.";
                        }

                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_post";
                        $response['icon'] = "warning";
                        $response['title'] = "No Post.";
                        $response['message'] = "No se enviaron los datos por el metodo Post.";
                    }
                    break;

                case 'eliminar_parroquia':
                    $model = new Parroquia();

                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $model->update($id,'band', 0);

                        //resto al contador de parroquias
                        $parroquia = $model->find($id);
                        $modelMunicipio = new Municipio();
                        $municipio = $modelMunicipio->find($parroquia['municipios_id']);
                        $count = $municipio['parroquias'] - 1 ;
                        $modelMunicipio->update($municipio['id'], 'parroquias', $count);

                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = false;
                        $response['icon'] = "success";
                        $response['title'] = "Parroquia Eliminada.";
                        $response['message'] = "Parroquia Eliminada Exitosamente.";
                        $response['total'] = $model->count(1);
                        $response['municipios_id'] = $municipio['id'];
                        $response['municipio_parroquias'] = $count;

                    }else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_post";
                        $response['icon'] = "warning";
                        $response['title'] = "No Post.";
                        $response['message'] = "No se enviaron los datos por el metodo Post.";
                    }
                    break;

                case 'get_municipios_select':

                    $model = new Municipio();
                    $response['result'] = true;
                    $response['municipios'] = array();
                    foreach ($model->getAll(1) as $municipio){
                        $id = $municipio['id'];
                        $nombre = $municipio['nombre'];
                        $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    break;

                case 'filtrar_parroquias':
                    $paginate = true;

                    $model = new Parroquia();
                    $limit = 100;
                    $cantidadParroquias = count($model->getList('municipios_id', '=', $_POST['id'], 1));
                    $listarParroquias = $model->paginate($limit, null, 'nombre', 'ASC', 1, 'municipios_id', '=', $_POST['id']);
                    $links = paginate('procesar_parroquia.php', 'tabla_parroquias', $limit, $cantidadParroquias, null, 'paginate_parroquia', 'dataContainerParroquia','_parroquia')->createLinks();
                    $i = 0;
                    echo '<div id="dataContainerParroquia">';
                    require_once "_layout/card_table_parroquias.php";
                    echo '</div>';

                    break;

                //Por defecto
                default:
                    $response['result'] = false;
                    $response['alerta'] = true;
                    $response['error'] = "no_opcion";
                    $response['icon'] = "warning";
                    $response['title'] = "Opcion no Programada.";
                    $response['message'] = "No se ha programado la logica para la case \"$opcion\":";
                    break;

            }


        } else {
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = "faltan_datos";
            $response['icon'] = "warning";
            $response['title'] = "Faltan datos.";
            $response['message'] = "La variable opcion no definida.";
        }
    } catch (PDOException $e) {
        $response['result'] = false;
        $response['alerta'] = true;
        $response['error'] = 'error_model';
        $response['icon'] = "error";
        $response['title'] = "Error en el Model";
        $response['message'] = "PDOException {$e->getMessage()}";
    } catch (Exception $e) {
        $response['result'] = false;
        $response['alerta'] = true;
        $response['error'] = 'error_model';
        $response['icon'] = "error";
        $response['title'] = "Error en el Model";
        $response['message'] = "General Error: {$e->getMessage()}";
    }
} else {
    $response['result'] = false;
    $response['alerta'] = true;
    $response['error'] = 'error_method';
    $response['icon'] = "error";
    $response['title'] = "Error Method.";
    $response['message'] = "Deben enviarse los datos por el method POST.";
}

if (!$paginate) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

