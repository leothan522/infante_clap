<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Bloque;

$response = array();
$paginate = false;

if ($_POST) {
    try {
        if (!empty($_POST['opcion'])) {
            $opcion = $_POST['opcion'];
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


                        if ($bloques['numero'] != $numero || $bloques['municipios_id'] != $municipios_id) {

                            $data = [
                                $numero,
                                $nombre,
                                $municipios_id
                            ];

                            $model->save($data);
                            $bloque = $model->first('numero', '=', $numero);
                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = "se_guardo";
                            $response['icon'] = "success";
                            $response['title'] = "Guardado exitosamente.";
                            $response['message'] = "Bloque guardado exitosamente.";
                            $response['id'] = $bloque['id'];
                            $response['item'] = $model->count();
                            $response['numero'] = $bloque['numero'];
                            $response['nombre'] = $bloque['nombre'];
                            $response['municipios_id'] = $bloque['municipios_id'];
                            $response['nuevo'] = true;
                            $response['total'] = $model->count();

                        } else {
                            //manejo el error
                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = "no_municipio";
                            $response['icon'] = "warning";
                            $response['title'] = "El numero de bloque esta repetido.";
                            $response['message'] = "Deben seleccionar un  municipio";
                        }
                    } else {
                        //manejo el error
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan Datos.";
                        $response['message'] = "Todos los datos deben enviarse, tanto el municipio como el nro de bloque y su nombre";
                    }
                    break;

                case 'get_bloque':
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $bloque = $model->find($id);
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = false;
                        $response['icon'] = "success";
                        $response['title'] = "Editar Bloque.";
                        $response['id'] = $bloque['id'];
                        $response['numero'] = $bloque['numero'];
                        $response['nombre'] = $bloque['nombre'];
                        $response['municipios_id'] = $bloque['municipios_id'];
                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan Datos.";
                        $response['message'] = "Todos los datos son requeridos.";
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
                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = "se_guardo";
                            $response['icon'] = "success";
                            $response['title'] = "Bloque Actualizado.";
                            $response['message'] = "El bloque se ha actualizado exitosamente.";
                            $response['id'] = $bloque['id'];
                            $response['numero'] = $bloque['numero'];
                            $response['nombre'] = $bloque['nombre'];
                            $response['total'] = $model->count();
                            $response['nuevo'] = false;
                        } else {
                            $response['result'] = false;
                            $response['alerta'] = true;
                            $response['error'] = "no_cambios";
                            $response['icon'] = "info";
                            $response['title'] = "Sin Cambios.";
                            $response['message'] = "No se realizo ningun cambio";
                        }


                    } else {
                        //manejo el error
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_post";
                        $response['icon'] = "warning";
                        $response['title'] = "No POST.";
                        $response['message'] = "Deben enviarse los datod por el metodo post";
                    }
                    break;

                case 'eliminar_bloque':
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];

                        $model->delete($id);
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = "se_guardo";
                        $response['icon'] = "success";
                        $response['title'] = "Bloque Eliminado.";
                        $response['message'] = "El bloque se ha eliminado exitosamente.";

                    } else {
                        //manejo el error
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_post";
                        $response['icon'] = "warning";
                        $response['title'] = "No POST.";
                        $response['message'] = "Deben enviarse los datod por el metodo post";
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
