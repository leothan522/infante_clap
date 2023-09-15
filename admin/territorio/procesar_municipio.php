<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Municipio;

$response = array();
$paginate = false;
if ($_POST) {

    try {
        if (!empty($_POST['opcion'])) {
            $opcion = $_POST['opcion'];


            switch ($opcion) {

                //definimos las opciones a procesar

                case 'paginate_municipio':
                    $paginate = true;

                    $model = new Municipio();

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';

                    $listarMunicipios = $model->paginate($limit, $offset, 'nombre', 'DESC', 1);
                    $links = paginate($baseURL, $tableID, $limit, $model->count(1), $offset, $opcion, 'dataContainerMunicipio')->createLinks();
                    $i = $offset;
                    echo '<div id="dataContainerMunicipio">';
                    require_once "_layout/card_table_municipios.php";
                    echo '</div>';

                    break;

                case 'guardar_municipio':
                    $model = new Municipio();

                    if (!empty($_POST['mun_municipio'])) {
                        //proceso
                        $nombre = ucwords($_POST['mun_municipio']);

                        $existe = $model->existe('nombre', '=', $nombre, null, 1);

                        if (!$existe) {
                            $data = [
                                $nombre
                            ];

                            $model->save($data);
                            $municipios = $model->first('nombre', '=', $nombre);
                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = false;
                            $response['icon'] = "success";
                            $response['title'] = "Municipio Creado Exitosamente.";
                            $response['message'] = "Municipio Creado " . $nombre;
                            $response['id'] = $municipios['id'];
                            $response['item'] = '<p> ' . $model->count(1) . '. </p>';
                            $response['nombre'] = $municipios['nombre'];
                            $response['parroquias'] = formatoMillares($municipios['parroquias'], 0);
                            $response['nuevo'] = true;

                        } else {
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = "nombre_duplicado";
                            $response['icon'] = "warning";
                            $response['title'] = "Nombre Duplicado.";
                            $response['message'] = "El nombre ya esta registrado.";
                        }
                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan Datos.";
                        $response['message'] = "Todos los datos sonm requeridos.";
                    }

                    break;

                case 'get_municipio':
                    $model = new Municipio();

                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $municipio = $model->find($id);
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = false;
                        $response['icon'] = "success";
                        $response['title'] = "Editar Muncipio.";
                        $response['message'] = "Municipio " . $municipio['nombre'];
                        $response['id'] = $municipio['id'];
                        $response['nombre'] = $municipio['nombre'];

                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan Datos.";
                        $response['message'] = "Todos los datos son requeridos.";
                    }


                    break;

                case 'editar_municipio':
                    $model = new Municipio();

                    if (
                        !empty($_POST['mun_municipio']) &&
                        !empty($_POST['id'])
                    ) {
                        //proceso
                        $id = $_POST['id'];
                        $nombre = ucwords($_POST['mun_municipio']);

                        $existe = $model->existe('nombre', '=', $nombre, $id, 1);

                        if (!$existe) {

                            $municipio = $model->find($id);
                            $db_nombre = $municipio['nombre'];

                            if ($db_nombre != $nombre) {
                                $model->update($id, 'nombre', $nombre);
                                $response['result'] = true;
                                $response['alerta'] = false;
                                $response['error'] = false;
                                $response['icon'] = "success";
                                $response['title'] = "Municipio Actualizado.";
                                $response['message'] = "Municipio Creado " . $nombre;
                                $response['id'] = $id;
                                $response['nombre'] = $nombre;
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

                        } else {
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = "nombre_duplicado";
                            $response['icon'] = "warning";
                            $response['title'] = "Nombre Duplicado.";
                            $response['message'] = "El nombre ya esta registrado.";
                        }
                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan Datos.";
                        $response['message'] = "Todos los datos sonm requeridos.";
                    }

                    break;

                case 'eliminar_municipio':
                    $model = new Municipio();

                    if (
                        !empty($_POST['id'])
                    ) {
                        //proceso
                        $id = $_POST['id'];
                        $model->update($id, 'band', 0);
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = false;
                        $response['icon'] = "success";
                        $response['title'] = "Municipio Eliminado.";
                        $response['message'] = "Municipio Eliminado.";

                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan Datos.";
                        $response['message'] = "Todos los datos sonm requeridos.";
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
