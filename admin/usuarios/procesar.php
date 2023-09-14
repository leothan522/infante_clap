<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\User;
use app\controller\UsersController;

$response = array();
$paginate = false;
$controller = new UsersController();

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            $model = new User();

            switch ($opcion) {

                //definimos las opciones a procesar

                case 'paginate':

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';

                    $listarUsuarios = $model->paginate($limit, $offset, 'role', 'DESC', 1);
                    $links = paginate($baseURL, $tableID, $limit, $model->count(1), $offset)->createLinks();
                    $i = $offset;
                    echo '<div id="dataContainer">';
                    require_once "_layout/card_table.php";
                    echo '</div>';

                    $paginate = true;

                    break;

                case 'generar_clave':

                    $password = generar_string_aleatorio();

                    $response['result'] = true;
                    $response['alerta'] = false;
                    $response['error'] = "no_opcion";
                    $response['icon'] = "info";
                    $response['title'] = "Contraseña Generada";
                    $response['message'] = $password;
                    break;

                case 'guardar':

                    if (validarPermisos('usuarios.create')){
                        if (
                            !empty($_POST['name']) &&
                            !empty($_POST['email']) &&
                            !empty($_POST['password']) &&
                            !empty($_POST['telefono']) &&
                            isset($_POST['tipo'])
                        ) {

                            $name = ucwords($_POST['name']);
                            $email = strtolower($_POST['email']);
                            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            $telefono = $_POST['telefono'];
                            $tipo = $_POST['tipo'];
                            $created_at = date('Y-m-d');

                            $existeEmail = $model->existe('email', '=', $email, null, 1);

                            if (!$existeEmail) {

                                $data = [
                                    $name,
                                    $email,
                                    $password,
                                    $telefono,
                                    $tipo,
                                    $created_at
                                ];

                                $model->save($data);

                                $user = $model->first('email', '=', $email);
                                $response['result'] = true;
                                $response['alerta'] = false;
                                $response['error'] = false;
                                $response['icon'] = "success";
                                $response['title'] = "Usuario Creado Exitosamente.";
                                $response['message'] = "Usuario Creado " . $name;
                                $response['id'] = $user['id'];
                                $response['name'] = $user['name'];
                                $response['email'] = $user['email'];
                                $response['telefono'] = '<p class="text-center">' . $user['telefono'] . '</p>';
                                $response['role'] = '<p class="text-center">' . verRoleUsuario($user['role']) . '</p>';
                                $response['item'] = '<p class="text-center">'.$model->count(1).'</p>';
                                $response['estatus'] = '<p class="text-center">' . verEstatusUsuario($user['estatus']) . '</p>';
                                $response['total'] = $model->count(1);

                            } else {
                                $response['result'] = false;
                                $response['alerta'] = false;
                                $response['error'] = 'email_duplicado';
                                $response['icon'] = "warning";
                                $response['title'] = "Email Duplicado.";
                                $response['message'] = "El email ya esta registrado.";
                            }

                        } else {
                            $response['result'] = false;
                            $response['alerta'] = true;
                            $response['error'] = "faltan_datos";
                            $response['icon'] = "warning";
                            $response['title'] = "Faltan datos.";
                            $response['message'] = "El nombre del parametro es obligatorio.";
                        }
                    }else{
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_permisos";
                        $response['icon'] = "warning";
                        $response['title'] = "Permiso Denegado.";
                        $response['message'] = "El usuario actual no tiene permisos suficientes para realizar esta acción. Contacte con su Administrador.";
                    }

                    break;

                case 'get_user':

                    if (!empty($_POST['id'])) {

                        $id = $_POST['id'];

                        $user = $model->find($id);

                        if ($user) {

                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = false;
                            $response['icon'] = "success";
                            $response['title'] = "Editar Usuario";
                            $response['message'] = "Mostrando Usuario " . $user['name'];
                            $response['id'] = $user['id'];
                            $response['name'] = $user['name'];
                            $response['email'] = $user['email'];
                            $response['telefono'] = $user['telefono'];
                            $response['tipo'] = verRoleUsuario($user['role']);
                            $response['estatus'] = verEstatusUsuario($user['estatus'], false);
                            $response['fecha'] = verFecha($user['created_at']);
                            $response['band'] = $user['estatus'];
                            $response['role'] = $user['role'];

                        } else {
                            $response['result'] = false;
                            $response['alerta'] = true;
                            $response['error'] = "no_user";
                            $response['icon'] = "warning";
                            $response['title'] = "Usuario NO encontrado.";
                            $response['message'] = "El id del usuario no esta disponible.";
                        }

                    } else {
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan datos.";
                        $response['message'] = "El nombre del parametro es obligatorio.";
                    }

                    break;

                case 'cambiar_estatus':

                    if (validarPermisos('usuarios.estatus')){
                        if (!empty($_POST['id'])) {

                            $id = $_POST['id'];

                            $user = $model->find($id);

                            if ($user) {

                                $estatus = $user['estatus'];

                                if ($estatus) {
                                    $model->update($id, 'estatus', 0);
                                    $title = 'Usuario Inactivo';
                                    $newEstatus = 0;
                                    $verEstatus = verEstatusUsuario(0, false);
                                } else {
                                    $model->update($id, 'estatus', 1);
                                    $title = 'Usuario Activo';
                                    $newEstatus = 1;
                                    $verEstatus = verEstatusUsuario(1, false);
                                }

                                $response['result'] = true;
                                $response['alerta'] = false;
                                $response['error'] = false;
                                $response['icon'] = "info";
                                $response['title'] = $title;
                                $response['message'] = "Mostrando Usuario " . $user['name'];
                                $response['id'] = $user['id'];
                                $response['name'] = $user['name'];
                                $response['email'] = $user['email'];
                                $response['telefono'] = $user['telefono'];
                                $response['tipo'] = verRoleUsuario($user['role']);
                                $response['estatus'] = $verEstatus;
                                $response['fecha'] = verFecha($user['created_at']);
                                $response['band'] = $newEstatus;
                                $response['role'] = $user['role'];
                                $response['table_estatus'] = '<p class="text-center">' . verEstatusUsuario($newEstatus) . '</p>';

                            } else {
                                $response['result'] = false;
                                $response['alerta'] = true;
                                $response['error'] = "no_user";
                                $response['icon'] = "warning";
                                $response['title'] = "Usuario NO encontrado.";
                                $response['message'] = "El id del usuario no esta disponible.";
                            }

                        } else {
                            $response['result'] = false;
                            $response['alerta'] = true;
                            $response['error'] = "faltan_datos";
                            $response['icon'] = "warning";
                            $response['title'] = "Faltan datos.";
                            $response['message'] = "El nombre del parametro es obligatorio.";
                        }
                    }else{
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_permisos";
                        $response['icon'] = "warning";
                        $response['title'] = "Permiso Denegado.";
                        $response['message'] = "El usuario actual no tiene permisos suficientes para realizar esta acción. Contacte con su Administrador.";
                    }

                    break;

                case 'reset_password':

                    if (validarPermisos('usuarios.reset')){
                        if (
                            !empty($_POST['id']) &&
                            isset($_POST['password'])
                        ) {

                            $id = $_POST['id'];
                            $password = $_POST['password'];

                            $user = $model->find($id);

                            if ($user) {

                                if (empty($password)){
                                    $password = generar_string_aleatorio();
                                }

                                $db_password = password_hash($password, PASSWORD_DEFAULT);

                                $model->update($id, 'password', $db_password);

                                $response['result'] = true;
                                $response['alerta'] = false;
                                $response['error'] = false;
                                $response['icon'] = "success";
                                $response['title'] = "Contraseña Guardada";
                                $response['message'] = $password;
                                $response['id'] = $user['id'];
                                $response['name'] = $user['name'];
                                $response['email'] = $user['email'];
                                $response['telefono'] = $user['telefono'];
                                $response['tipo'] = verRoleUsuario($user['role']);
                                $response['estatus'] = verEstatusUsuario($user['estatus'], false);
                                $response['fecha'] = verFecha($user['created_at']);
                                $response['band'] = $user['estatus'];
                                $response['role'] = $user['role'];

                            } else {
                                $response['result'] = false;
                                $response['alerta'] = true;
                                $response['error'] = "no_user";
                                $response['icon'] = "warning";
                                $response['title'] = "Usuario NO encontrado.";
                                $response['message'] = "El id del usuario no esta disponible.";
                            }

                        } else {
                            $response['result'] = false;
                            $response['alerta'] = true;
                            $response['error'] = "faltan_datos";
                            $response['icon'] = "warning";
                            $response['title'] = "Faltan datos.";
                            $response['message'] = "El nombre del parametro es obligatorio.";
                        }

                    }else{
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_permisos";
                        $response['icon'] = "warning";
                        $response['title'] = "Permiso Denegado.";
                        $response['message'] = "El usuario actual no tiene permisos suficientes para realizar esta acción. Contacte con su Administrador.";
                    }

                    break;

                case 'editar':

                    if (validarPermisos('usuarios.edit')){
                        if (
                            !empty($_POST['name']) &&
                            !empty($_POST['email']) &&
                            !empty($_POST['telefono']) &&
                            isset($_POST['tipo']) &&
                            !empty($_POST['id'])
                        ) {

                            $id = $_POST['id'];
                            $name = ucwords($_POST['name']);
                            $email = strtolower($_POST['email']);
                            $telefono = $_POST['telefono'];
                            $tipo = $_POST['tipo'];
                            $updated_at = date('Y-m-d');

                            $existeEmail = $model->existe('email', '=', $email, $id, 1);

                            if (!$existeEmail) {

                                $user = $model->find($id);
                                $db_name = $user['name'];
                                $db_email = $user['email'];
                                $db_telefono = $user['telefono'];
                                $db_tipo = $user['role'];

                                $cambios = false;

                                if ($db_name != $name){
                                    $cambios = true;
                                    $model->update($id, 'name', $name);
                                }

                                if ($db_email != $email){
                                    $cambios = true;
                                    $model->update($id, 'email', $email);
                                }

                                if ($db_telefono != $telefono){
                                    $cambios = true;
                                    $model->update($id, 'telefono', $telefono);
                                }

                                if ($db_tipo != $tipo){
                                    $cambios = true;
                                    $model->update($id, 'role', $tipo);
                                }

                                if ($cambios){

                                    $model->update($id, 'updated_at', $updated_at);

                                    $user = $model->find($id);

                                    $response['result'] = true;
                                    $response['alerta'] = false;
                                    $response['error'] = false;
                                    $response['icon'] = "success";
                                    $response['title'] = "Cambios Guardados";
                                    $response['message'] = "Usuario Creado " . $name;
                                    $response['id'] = $user['id'];
                                    $response['name'] = $user['name'];
                                    $response['email'] = $user['email'];
                                    $response['telefono'] = $user['telefono'];
                                    $response['tipo'] = verRoleUsuario($user['role']);
                                    $response['estatus'] = verEstatusUsuario($user['estatus'], false);
                                    $response['fecha'] = verFecha($user['created_at']);
                                    $response['band'] = $user['estatus'];
                                    $response['role'] = $user['role'];
                                    $response['table_telefono'] = '<p class="text-center">' . $user['telefono'] . '</p>';
                                    $response['table_role'] = '<p class="text-center">' . verRoleUsuario($user['role']) . '</p>';

                                }else{
                                    $response['result'] = false;
                                    $response['alerta'] = true;
                                    $response['error'] = "no_cambios";
                                    $response['icon'] = "info";
                                    $response['title'] = "Sin Cambios.";
                                    $response['message'] = "No se realizo ningun cambio.";
                                }

                            } else {
                                $response['result'] = false;
                                $response['alerta'] = false;
                                $response['error'] = 'email_duplicado';
                                $response['icon'] = "warning";
                                $response['title'] = "Email Duplicado.";
                                $response['message'] = "El email ya esta registrado.";
                            }

                        } else {
                            $response['result'] = false;
                            $response['alerta'] = true;
                            $response['error'] = "faltan_datos";
                            $response['icon'] = "warning";
                            $response['title'] = "Faltan datos.";
                            $response['message'] = "El nombre del parametro es obligatorio.";
                        }
                    }else{
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_permisos";
                        $response['icon'] = "warning";
                        $response['title'] = "Permiso Denegado.";
                        $response['message'] = "El usuario actual no tiene permisos suficientes para realizar esta acción. Contacte con su Administrador.";
                    }

                    break;

                case 'eliminar':

                    if (validarPermisos('usuarios.destroy')){
                        if (!empty($_POST['id'])) {

                            $id = $_POST['id'];
                            $user = $model->find($id);

                            if ($user) {

                                $model->update($id, 'band', 0);
                                $model->update($id, 'deleted_at', date("Y-m-d"));

                                $response['result'] = true;
                                $response['alerta'] = false;
                                $response['error'] = false;
                                $response['icon'] = "success";
                                $response['title'] = "Usuario Eliminado";
                                $response['message'] = "Usuario Eliminado";
                                $response['total'] = $model->count(1);

                            } else {
                                $response['result'] = false;
                                $response['alerta'] = true;
                                $response['error'] = "no_user";
                                $response['icon'] = "warning";
                                $response['title'] = "Usuario NO encontrado.";
                                $response['message'] = "El id del usuario no esta disponible.";
                            }

                        } else {
                            $response['result'] = false;
                            $response['alerta'] = true;
                            $response['error'] = "faltan_datos";
                            $response['icon'] = "warning";
                            $response['title'] = "Faltan datos.";
                            $response['message'] = "El nombre del parametro es obligatorio.";
                        }
                    }else{
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_permisos";
                        $response['icon'] = "warning";
                        $response['title'] = "Permiso Denegado.";
                        $response['message'] = "El usuario actual no tiene permisos suficientes para realizar esta acción. Contacte con su Administrador.";
                    }

                    break;

                case 'get_permisos':

                    if (!empty($_POST['id'])){

                        $id = $_POST['id'];
                        $user = $model->find($id);

                        $response['result'] = true;
                        $response['alerta'] = false;
                        $response['error'] = false;
                        $response['icon'] = "info";
                        $response['title'] = "Ver Permisos";
                        $response['message'] = "Mostrando Usuario " . $user['name'];
                        $response['id'] = $user['id'];
                        $response['name'] = $user['name'];
                        $response['email'] = $user['email'];
                        $response['tipo'] = verRoleUsuario($user['role']);
                        if (!is_null($user['permisos'])){
                            $response['user_permisos'] = json_decode($user['permisos']);
                        }else{
                            $response['user_permisos'] = null;
                        }
                        $permisos = verPermisos();
                        $response['permisos'] = $permisos[1];


                    }else{
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "faltan_datos";
                        $response['icon'] = "warning";
                        $response['title'] = "Faltan datos.";
                        $response['message'] = "La variable opcion no definida.";
                    }

                    break;

                case 'guarda_permisos':

                    if (validarPermisos()){
                        if (!empty($_POST['id'])){

                            $id = $_POST['id'];
                            $user = $model->find($id);

                            $contador = $_POST['contador'];
                            $permisos = array();
                            for ($i = 1; $i <= $contador; $i++){
                                if (isset($_POST['permiso_'.$i])){
                                    $permiso = $_POST['permiso_'.$i];
                                    $permisos[] = $permiso;
                                }
                            }

                            $model->update($id, 'permisos', crearJson($permisos));

                            $response['result'] = true;
                            $response['alerta'] = false;
                            $response['error'] = false;
                            $response['icon'] = "success";
                            $response['title'] = "Permisos Guardados";
                            $response['message'] = "Mostrando Usuario " . $user['name'];
                            $response['id'] = $user['id'];
                            $response['name'] = $user['name'];
                            $response['email'] = $user['email'];
                            $response['tipo'] = verRoleUsuario($user['role']);
                            if (!is_null($user['permisos'])){
                                $response['user_permisos'] = json_decode($user['permisos']);
                            }else{
                                $response['user_permisos'] = null;
                            }
                            $permisos = verPermisos();
                            $response['permisos'] = $permisos[1];


                        }else{
                            $response['result'] = false;
                            $response['alerta'] = true;
                            $response['error'] = "faltan_datos";
                            $response['icon'] = "warning";
                            $response['title'] = "Faltan datos.";
                            $response['message'] = "La variable opcion no definida.";
                        }


                    }else{
                        $response['result'] = false;
                        $response['alerta'] = true;
                        $response['error'] = "no_permisos";
                        $response['icon'] = "warning";
                        $response['title'] = "Permiso Denegado.";
                        $response['message'] = "El usuario actual no tiene permisos suficientes para realizar esta acción. Contacte con su Administrador.";
                    }

                    break;

                //Por defecto
                default:
                    $response['result'] = false;
                    $response['alerta'] = true;
                    $response['error'] = "no_opcion";
                    $response['icon'] = "warning";
                    $response['title'] = "Opcion no Programada.";
                    $response['message'] = "No se ha programado la logica para la opcion \"$opcion\"";
                    break;
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
        $response['error'] = "faltan_datos";
        $response['icon'] = "warning";
        $response['title'] = "Faltan datos.";
        $response['message'] = "La variable opcion no definida.";
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
