<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\PerfilController;
$controller = new PerfilController();
use app\model\User;

$response = array();

if ($_POST) if (!empty($_POST['opcion'])) {

    $opcion = $_POST['opcion'];

    try {

        switch ($opcion) {

            //definimos las opciones a procesar
            case 'update':

                if (
                    !empty($_POST['name']) &&
                    !empty($_POST['email']) &&
                    !empty($_POST['telefono']) &&
                    !empty($_POST['password'])
                ) {
                    //datos recibidospor el POST
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $telefono = $_POST['telefono'];
                    $password = $_POST['password'];
                    $response = $controller->update($password, $name, $email, $telefono);
                } else {
                    $response = crearResponse('faltan_datos');
                }

                break;

            case "set_password":

                if (
                    !empty($_POST['contrasea_actual']) &&
                    !empty($_POST['contrasea_nueva'])
                ) {
                    $old_password = $_POST['contrasea_actual'];
                    $new_password = $_POST['contrasea_nueva'];
                    $response = $controller->setPassword($old_password, $new_password);
                } else {
                    //manejo los errores
                    $response = crearResponse('faltan_datos');
                }

                break;

            case 'store_imagen':
                $model = new User();
                if(isset($_FILES['seleccionar_imagen'])){
                    $imagen = $_FILES['seleccionar_imagen']; // Acceder al archivo de imagen
                    $nombreImagen = $imagen['name']; // Obtener el nombre del archivo
                    $temporal = $imagen['tmp_name']; // Obtener el nombre temporal del archivo
                    $id = $controller->USER_ID;

                    // Definir la ruta donde se guardará la imagen
                    $dir = 'public/img/profile/';
                    $carpetaDestino = "../../../". $dir;
                    $rutaDestino = $carpetaDestino . $nombreImagen;
                    $path = $dir . $nombreImagen;

                    // Mover el archivo de la ubicación temporal a la carpeta de destino
                    if(move_uploaded_file($temporal, $rutaDestino)){
                        $model->update($id, 'path', $path);
                        $response = crearResponse(
                            false,
                            true,
                            'Subida Exitosamente.',
                            'Subida Exitosamente.'
                        );
                        $response['path'] = public_url($path);
                    } else {
                        $response = crearResponse(
                            false,
                            true,
                            'Hubo un error.',
                            'Hubo un error.'
                        );
                    }
                }else{
                    $response = ('faltan_datos');
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
} else {
    $response = crearResponse('error_method');
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

