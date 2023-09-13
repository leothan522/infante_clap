<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Municipio;

$response = array();

if ($_POST) {

    try {
        if (!empty($_POST['opcion'])) {
            $opcion = $_POST['opcion'];


            switch ($opcion) {

                //definimos las opciones a procesar
                case 'guardar_municipio':
                    $model = new Municipio();

                    if (!empty($_POST['mun_municipio'])){
                        //proceso
                        $nombre = ucwords($_POST['mun_municipio']);

                        $existe = $model->existe('nombre', '=', $nombre, null, 1);

                        if (!$existe){
                            $data = [
                                $nombre
                            ];

                            $model->save($data);
                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = false;
                            $response['icon'] = "success";
                            $response['title'] = "Municipio Creado Exitosamente.";
                            $response['message'] = "Municipio Creado " . $nombre;
                        }else{
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = "nombre_duplicado";
                            $response['icon'] = "warning";
                            $response['title'] = "Nombre Duplicado.";
                            $response['message'] = "El nombre ya esta registrado.";
                        }
                    }else{
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

                    if (!empty($_POST['id'])){
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

                    }else{
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
                    ){
                        //proceso
                        $id = $_POST['id'];
                        $nombre = ucwords($_POST['mun_municipio']);

                        $existe = $model->existe('nombre', '=', $nombre, $id, 1);

                        if (!$existe){

                            $municipio = $model->find($id);
                            $db_nombre = $municipio['nombre'];

                            if ($db_nombre != $nombre){
                                $model->update($id, 'nombre', $nombre);
                                $response['result'] = true;
                                $response['alerta'] = false;
                                $response['error'] = false;
                                $response['icon'] = "success";
                                $response['title'] = "Municipio Actualizado.";
                                $response['message'] = "Municipio Creado " . $nombre;
                            }else{
                                $response['result'] = false;
                                $response['alerta'] = true;
                                $response['error'] = "no_cambios";
                                $response['icon'] = "warning";
                                $response['title'] = "Sin Cambios.";
                                $response['message'] = "No se realizaron Cambios.";
                            }

                        }else{
                            $response['result'] = false;
                            $response['alerta'] = false;
                            $response['error'] = "nombre_duplicado";
                            $response['icon'] = "warning";
                            $response['title'] = "Nombre Duplicado.";
                            $response['message'] = "El nombre ya esta registrado.";
                        }
                    }else{
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
                    ){
                        //proceso
                        $id = $_POST['id'];
                        $model->update($id, 'band', 0);
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = false;
                        $response['icon'] = "success";
                        $response['title'] = "Municipio Eliminado.";
                        $response['message'] = "Municipio Eliminado.";

                    }else{
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
echo json_encode($response, JSON_UNESCAPED_UNICODE);

