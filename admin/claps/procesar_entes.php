<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Ente;

$response = array();
$paginate = false;

if ($_POST) try {
    if (!empty($_POST['opcion'])) {
        $opcion = $_POST['opcion'];
        $model = new Ente();
        switch ($opcion) {

            //definimos las opciones a procesar

            case 'guardar_ente':
                if (!empty($_POST['entes_nombre'])){
                    $nombre = $_POST['entes_nombre'];

                    $existe = $model->existe('nombre', '=', $nombre);

                    if (!$existe){

                        $data = [
                          $nombre
                        ];

                        $model->save($data);
                        $entes = $model->first('nombre', '=', $nombre);
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = "se_guardo";
                        $response['icon'] = "success";
                        $response['title'] = "Ente registrado.";
                        $response['message'] = "El nombre se registro perfectamente.";
                        $response['nombre'] = $entes['nombre'];
                        $response['nuevo'] = true;
                    }else{
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = "nombre_duplicado";
                        $response['icon'] = "warning";
                        $response['title'] = "Nombre duplicado.";
                        $response['message'] = "El nombre ya se encuentra registrado.";
                    }

                }else{
                    $response['result'] = false;
                    $response['alerta'] = true;
                    $response['error'] = "faltan_datos";
                    $response['icon'] = "warning";
                    $response['title'] = "Faltan Datos.";
                    $response['message'] = "Debe enviar todos los datos.";
                }
                break;

            case 'get_ente':
                if (!empty($_POST['id'])){
                    $id = $_POST['id'];
                    $ente = $model->find($id);
                    $response['result'] = true;
                    $response['alerta'] = false;
                    $response['error'] = false;
                    $response['icon'] = "success";
                    $response['title'] = "Editar Ente.";
                    $response['id'] = $ente['id'];
                    $response['nombre'] = $ente['nombre'];
                }else{
                    $response['result'] = false;
                    $response['alerta'] = true;
                    $response['error'] = "faltan_datos";
                    $response['icon'] = "warning";
                    $response['title'] = "Faltan Datos.";
                    $response['message'] = "Debe enviar todos los datos.";
                }
                break;

            case 'editar_ente':
                if (!empty($_POST['entes_nombre'])){
                    $nombre = $_POST['entes_nombre'];
                    $id = $_POST['id'];

                    $existe = $model->existe('nombre', '=', $nombre);

                    if (!$existe){
                        $model->update($id,'nombre', $nombre);
                        $ente = $model->first('nombre', '=', $nombre);
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = "se_guardo";
                        $response['icon'] = "success";
                        $response['title'] = "Ente Actualizado Exitosamente.";
                        $response['message'] = "El nombre se actualizo perfectamente.";
                        $response['id'] = $ente['id'];
                        $response['nombre'] = $ente['nombre'];
                        $response['nuevo'] = true;
                    }else{
                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = "nombre_duplicado";
                        $response['icon'] = "warning";
                        $response['title'] = "Nombre duplicado.";
                        $response['message'] = "El nombre ya se encuentra registrado.";
                    }

                }else{
                    $response['result'] = false;
                    $response['alerta'] = true;
                    $response['error'] = "faltan_datos";
                    $response['icon'] = "warning";
                    $response['title'] = "Faltan Datos.";
                    $response['message'] = "Debe enviar todos los datos.";
                }
                break;

            case 'eliminar_ente':
                if (!empty($_POST['id'])) {
                    $id = $_POST['id'];

                    $model->delete($id);
                    $response['result'] = true;
                    $response['alerta'] = false;
                    $response['error'] = "se_elimino";
                    $response['icon'] = "success";
                    $response['title'] = "Ente Eliminado.";
                    $response['message'] = "El ente se ha eliminado exitosamente.";

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
