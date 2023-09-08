<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\RolesController;
$controller = new RolesController();

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            switch ($opcion) {

                //definimos las opciones a procesar
                case 'store':

                    if (validarPermisos()){
                        if (!empty($_POST['nombre'])){
                            $nombre = $_POST['nombre'];
                            $response = $controller->store($nombre);
                        }else{
                            $response = crearResponse('faltan_datos');
                        }
                    }else{
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'edit':

                    if (!empty($_POST['id'])) {

                        $id = $_POST['id'];
                        $response = $controller->edit($id);
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'update':

                    if (validarPermisos()){
                        if (!empty($_POST['id'])) {

                            $id = $_POST['id'];
                            $nombre = $_POST['nombre'];
                            $contador = $_POST['contador'];
                            $permisos = array();
                            for ($i = 1; $i <= $contador; $i++) {
                                if (isset($_POST['permiso_' . $i])) {
                                    $permiso = $_POST['permiso_' . $i];
                                    $permisos[] = $permiso;
                                }
                            }
                            $response = $controller->update($id, $nombre, $permisos);
                        } else {
                            $response = crearResponse('faltas_datos');
                        }
                    }else{
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'delete':

                    if (validarPermisos()){
                        if (!empty($_POST['id'])) {
                            $id = $_POST['id'];
                            $response = $controller->delete($id);
                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    }else{
                        $response = crearResponse('no_permisos');
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

if (!$paginate){
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
