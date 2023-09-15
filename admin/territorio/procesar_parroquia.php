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
                    $links = paginate($baseURL, $tableID, $limit, $model->count(1), $offset, $opcion, 'dataContainerParroquia')->createLinks();
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
                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = false;
                            $response['icon'] = "success";
                            $response['title'] = "Parroquia Creada Exitosamente.";
                            $response['message'] = "Parroquia Creado exitosamente" . $parroquia;
                            $response['id'] = $parroquias['id'];
                            $response['item'] = '<p class="text-center">'.$model->count(1).'.</p>';
                            $response['municipio'] = $municipio['nombre'];
                            $response['parroquia'] = $parroquias['nombre'];
                            $response['nuevo'] = true;



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

                            if ($db_municipio != $municipio){
                                $procesar = true;
                                $model->update($id, 'municipios_id', $municipio);
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
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = false;
                        $response['icon'] = "success";
                        $response['title'] = "Parroquia Eliminada.";
                        $response['message'] = "Parroquia Eliminada Exitosamente.";
                    }else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_post";
                        $response['icon'] = "warning";
                        $response['title'] = "No Post.";
                        $response['message'] = "No se enviaron los datos por el metodo Post.";
                    }
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

