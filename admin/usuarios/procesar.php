<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\User;
use app\controller\UsersController;
use app\model\Municipio;

$response = array();
$paginate = false;


if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            $model = new User();

            switch ($opcion) {

                //definimos las opciones a procesar

                case 'paginate':
                    //$controller = new UsersController();
                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';

                    $listarUsuarios = $model->paginate($limit, $offset, 'role', 'DESC', 1);
                    $links = paginate($baseURL, $tableID, $limit, $model->count(1), $offset)->createLinks();
                    $i = $offset;
                    $user = $model->find($_SESSION['id']);
                    $user_role = $user['role'];
                    echo '<div id="dataContainer">';
                    require_once "_layout/card_table.php";
                    echo '</div>';

                    $paginate = true;

                    break;

                case 'generar_clave':

                    $password = generar_string_aleatorio();
                    $response = crearResponse(
                        null,
                        true,
                        'Contraseña Generada.',
                        $password,
                        'info',
                        false,
                        true
                    );

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
                                $response = crearResponse(
                                    null,
                                    true,
                                    'Usuario Creado Exitosamente.',
                                    "Usuario Creado " . $name
                                );
                                //datos extras para el $response
                                $response['id'] = $user['id'];
                                $response['name'] = $user['name'];
                                $response['email'] = $user['email'];
                                $response['telefono'] = '<p class="text-center">' . $user['telefono'] . '</p>';
                                $response['role'] = '<p class="text-center">' . verRoleUsuario($user['role']) . '</p>';
                                $response['item'] = '<p class="text-center">'.$model->count(1).'</p>';
                                $response['estatus'] = '<p class="text-center">' . verEstatusUsuario($user['estatus']) . '</p>';
                                $response['total'] = $model->count(1);
                                $response['btn_editar'] = validarPermisos('usuarios.edit');
                                $response['btn_eliminar'] = validarPermisos('usuarios.destroy');
                                $response['btn_permisos'] = validarPermisos();

                            } else {
                                $response = crearResponse(
                                    'email_duplicado',
                                    false,
                                    'Email Duplicado.',
                                    'El email ya esta registrado.',
                                    'warning'
                                );
                            }

                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    }else{
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'get_user':

                    if (!empty($_POST['id'])) {

                        $id = $_POST['id'];

                        $user = $model->find($id);

                        if ($user) {

                            $response = crearResponse(
                                null,
                                true,
                                'Editar Usuario.',
                                "Mostrando Usuario " . $user['name'],
                                'success',
                                false,
                                true
                            );
                            //datos extras para el $response
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
                            $response = crearResponse(
                                'no_user',
                                false,
                                'Usuario NO encontrado.',
                                'El id del usuario no esta disponible.',
                                'warning',
                                true
                            );
                        }
                    } else {
                        $response = crearResponse('faltan_datos');
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
                                    $icono = 'info';
                                    $newEstatus = 0;
                                    $verEstatus = verEstatusUsuario(0, false);
                                } else {
                                    $model->update($id, 'estatus', 1);
                                    $title = 'Usuario Activo';
                                    $icono = 'success';
                                    $newEstatus = 1;
                                    $verEstatus = verEstatusUsuario(1, false);
                                }

                                $response = crearResponse(
                                    null,
                                    true,
                                    $title,
                                    "Mostrando Usuario " . $user['name'],
                                    $icono
                                );
                                //datos extra para el $response
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
                                $response = crearResponse(
                                    'no_user',
                                    false,
                                    'Usuario NO encontrado."',
                                    'El id del usuario no esta disponible.',
                                    'warning',
                                    true
                                );
                            }

                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    }else{
                        $response = crearResponse('no_permisos');
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

                                $response = crearResponse(
                                    null,
                                    true,
                                    'Contraseña Guardada.',
                                    $password
                                );
                                //datos extras para el $response
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
                                $response = crearResponse(
                                    'no_user',
                                    false,
                                    'Usuario NO encontrado."',
                                    'El id del usuario no esta disponible.',
                                    'warning',
                                    true
                                );
                            }

                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    }else{
                        $response = crearResponse('no_permisos');
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

                                    $response = crearResponse(
                                        null,
                                        true,
                                        'Cambios Guardados.',
                                        $name." Actualizado."
                                    );
                                    //datos extras para el $response
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
                                    $response = crearResponse('no_cambios');
                                }

                            } else {
                                $response = crearResponse(
                                    'email_duplicado',
                                    false,
                                    'Email Duplicado.',
                                    'El email ya esta registrado.',
                                    'warning'
                                );
                            }
                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    }else{
                        $response = crearResponse('no_permisos');
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

                                $response = crearResponse(
                                    null,
                                    true,
                                    'Usuario Eliminado.',
                                    'Usuario Eliminado.'
                                );
                                //datos extras para el $response
                                $response['total'] = $model->count(1);

                            } else {
                                $response = crearResponse(
                                    'no_user',
                                    false,
                                    'Usuario NO encontrado."',
                                    'El id del usuario no esta disponible.',
                                    'warning',
                                    true
                                );
                            }

                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    }else{
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'get_permisos':

                    if (!empty($_POST['id'])){

                        $id = $_POST['id'];
                        $user = $model->find($id);

                        $response = crearResponse(
                            null,
                            true,
                            'Ver Permisos.',
                            "Mostrando Usuario " . $user['name'],
                            'info',
                            false,
                            true
                        );
                        //datos extras para el $response
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
                        $response = crearResponse('faltan_datos');
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

                            $response = crearResponse(
                                null,
                                true,
                                'Permisos Guardados.',
                                "Mostrando Usuario " . $user['name']
                            );
                            //datos extras para el response
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
                            $response = crearResponse('faltas_datos');
                        }

                    }else{
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'guarda_acceso':

                    if (validarPermisos()){

                        if (!empty($_POST['id'])){

                            $id = $_POST['id'];
                            $user = $model->find($id);
                            $hiola = null;

                            $contador = $_POST['contador'];
                            $permisos = array();
                            for ($i = 1; $i <= $contador; $i++){
                                if (isset($_POST['permiso_'.$i])){
                                    $permiso = $_POST['permiso_'.$i];
                                    $permisos[] = $permiso;
                                }
                            }

                            $model->update($id, 'permisos', crearJson($permisos));

                            $response = crearResponse(
                                null,
                                true,
                                'Permisos Guardados.',
                                "Mostrando Usuario " . $user['name']
                            );
                            //datos extras para el response
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
                            $response = crearResponse('faltas_datos');
                        }

                    }else{
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'get_usuarios_municipios':
                    $modelmunicipio = new municipio();

                    $response = crearResponse(null, true, null, null, 'success', false, true);

                    foreach ($modelmunicipio->getAll() as $municipio) {
                        $id = $municipio['id'];
                        $nombre = $municipio['mini'];
                        $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    foreach ($model->getAll(1) as $user){
                        $id = $user['id'];
                        $email = $user['email'];
                        $nombre = $user['name'];
                        $response['usuarios'][] = array("id" => $id, "email" => $email, "name" => $nombre);
                    }
                    break;

                case 'get_acceso_municipios':
                    $paginate = true;
                    require_once '_layout/card_table_acceso.php';

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
