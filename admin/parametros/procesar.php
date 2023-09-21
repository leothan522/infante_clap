<?php
session_start();
require_once "../../vendor/autoload.php";

use app\database\Query;
use app\model\Parametro;

$response = array();

if ($_POST) {
    $model = new Parametro();
    $paginate = false;
    try {
        if (!empty($_POST['opcion'])) {
            $opcion = $_POST['opcion'];


            switch ($opcion) {

                //definimos las opciones a procesar

                case "guardar":

                    if (!empty($_POST['name'])) {

                        $name = $_POST['name'];
                        $tabla_id = $_POST['tabla_id'];
                        $valor = $_POST['valor'];

                        if (empty($tabla_id)) {
                            if ($tabla_id != 0){
                                $tabla_id = null;
                            }
                            $tabla_id_sql = "";
                        } else {
                            $tabla_id_sql = "AND `tabla_id` = '$tabla_id'";
                        }

                        $data = [
                            $name,
                            $tabla_id,
                            $valor
                        ];

                        $model->save($data);

                        $query = new Query();
                        $sql = "SELECT *FROM `parametros` WHERE `nombre` = '$name' $tabla_id_sql  AND `valor` = '$valor' ORDER BY `id` DESC;";
                        $row = $query->getFirst($sql);


                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = 'cambios';
                        $response['icon'] = "success";
                        $response['title'] = "Permiso Agregado.";
                        $response['message'] = "Parametro agregado.";
                        $response['id'] = $row['id'];
                        $response['nombre'] = $row['nombre'];
                        $response['tabla_id'] = $row['tabla_id'];
                        $response['valor'] = $row['valor'];
                        $response['item'] = $model->count();
                        $response['add'] = true;
                        $response['total'] = $model->count();

                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan datos.";
                        $response['message'] = "El nombre del parametro es obligatorio.";
                    }


                    break;

                case "get_parametro":
                    if (!empty($_POST['id'])) {

                        $id = $_POST['id'];
                        $row = $model->find($id);

                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['icon'] = "info";
                        $response['title'] = "Editar Parametro.";
                        $response['id'] = $row['id'];
                        $response['nombre'] = $row['nombre'];
                        $response['tabla_id'] = $row['tabla_id'];
                        $response['valor'] = $row['valor'];


                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan datos.";
                        $response['message'] = "ID no definido.";
                    }

                    break;

                case "editar":

                    if (!empty($_POST['name'] && !empty($_POST['id']))) {

                        $nombre = $_POST['name'];
                        $tabla_id = $_POST['tabla_id'];
                        $valor = $_POST['valor'];
                        $id = $_POST['id'];

                        if (empty($tabla_id)) {
                            $tabla_id = null;
                        }

                        $getParametro = $model->find($id);
                        $db_nombre = $getParametro['nombre'];
                        $db_tabla_id = $getParametro['tabla_id'];
                        $db_valor = $getParametro['valor'];

                        $cambios = false;


                        if ($db_nombre != $nombre) {
                            $cambios = true;
                            $model->update($id, "nombre", $nombre);
                        }

                        if ($db_tabla_id != $tabla_id) {
                            $cambios = true;
                            $model->update($id, "tabla_id", $tabla_id);
                        }

                        if ($db_valor != $valor) {
                            $cambios = true;
                            $model->update($id, 'valor', $valor);
                        }


                        if ($cambios) {
                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['icon'] = "success";
                            $response['title'] = "Parametro Actualizado.";
                            $response['message'] = "Parametro Actualizado";
                            $response['id'] = $id;
                            $response['nombre'] = $nombre;
                            $response['tabla_id'] = $tabla_id;
                            $response['valor'] = $valor;
                        } else {
                            $response['result'] = false;
                            $response['alerta'] = true;
                            $response['error'] = "no_cambios";
                            $response['icon'] = "info";
                            $response['title'] = "Sin Cambios.";
                            $response['message'] = "No se realizo ningun cambio.";
                        }
                    }

                    break;

                case "eliminar":
                    if (!empty($_POST['id'])) {

                        $id = $_POST['id'];

                        $model->delete($id);

                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['icon'] = "success";
                        $response['title'] = "Parametro Borrado.";
                        $response['total'] = $model->count();

                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan datos.";
                        $response['message'] = "La variable ID no definida.";
                    }
                    break;

                case 'paginate':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'procesar.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_parametros';

                    echo '<div id="dataContainer">';
                    $listarParametros = $model->paginate($limit, $offset);
                    $linksPaginate = paginate('procesar.php','table_parametros', $limit, $totalRows, $offset)->createLinks();
                    $i = $offset;
                    require_once "_layout/table.php";
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

if (!$paginate){
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
