<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Ente;

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {
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
                            $response = crearResponse(
                                null,
                                true,
                                'Ente registrado.',
                                'El nombre se registro perfectamente.'
                            );
                            $response['id'] = $entes['id'];
                            $response['item'] = '<p class="text-center"> ' . $model->count() . ' </p>';
                            $response['nombre'] = '<p class="text-uppercase"> ' . $entes['nombre'] . ' </p>';
                            $response['nuevo'] = true;
                            $response['total'] = $model->count();
                        }else{
                            $response = crearResponse(
                                'nombre_duplicado',
                                false,
                                'Nombre duplicado.',
                                'El nombre ya se encuentra registrado.',
                                'warning'
                            );
                        }

                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_ente':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $ente = $model->find($id);
                        $response = crearResponse(
                            null,
                            true,
                            'Editar Ente.',
                            'Editar Ente.'
                        );
                        $response['id'] = $ente['id'];
                        $response['nombre'] = $ente['nombre'];
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'editar_ente':
                    if (!empty($_POST['entes_nombre'])){
                        $nombre = $_POST['entes_nombre'];
                        $id = $_POST['id'];

                        $existe = $model->existe('nombre', '=', $nombre, $id);

                        if (!$existe){
                            $bloques = $model->find($id);
                            if ($bloques['nombre'] != $nombre){
                                $model->update($id,'nombre', $nombre);
                                $ente = $model->first('nombre', '=', $nombre);
                                $response = crearResponse(
                                    null,
                                    true,
                                    'Ente Actualizado Exitosamente.',
                                    'El nombre se actualizo perfectamente.'
                                );
                                $response['id'] = $ente['id'];
                                $response['nombre'] = '<p class="text-uppercase"> ' . $ente['nombre'] . ' </p>';
                                $response['total'] = $model->count();
                                $response['item'] = '<p class="text-center"> ' . $model->count() . ' </p>';
                                $response['nuevo'] = false;
                            }else{
                                $response = crearResponse('no_cambios');
                                $response['item'] = $model->count();
                            }
                        }else{
                            $response = crearResponse(
                                'nombre_duplicado',
                                false,
                                'Nombre duplicado.',
                                'El nombre ya se encuentra registrado.',
                                'warning'
                            );
                        }

                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'eliminar_ente':
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];

                        $model->delete($id);
                        $response = crearResponse(
                            null,
                            true,
                            'Ente Eliminado.',
                            'El ente se ha eliminado exitosamente.'
                        );

                    } else {
                        //manejo el error
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_entes':
                    $paginate = true;
                    $model = new Ente();
                    $listarBloques = $model->getAll();

                    require '_layout/table_entes.php';
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
