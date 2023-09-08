<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\UsersController;
$controller = new UsersController();
use app\model\User;


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
                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';

                    $controller->index($baseURL, $tableID, $limit, $totalRows, $offset);
                    require_once "../_layout/card_table.php";

                    break;

                case 'index':
                    $paginate = true;
                    $controller->index();
                    require_once "../_layout/card_table.php";
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

                case 'store':

                    if (validarPermisos('usuarios.create')) {
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
                            $response = $controller->store($name, $email, $password, $telefono, $tipo);
                            if ($response['result']){
                                $paginate = true;
                                $controller->index();
                                require_once "../_layout/card_table.php";
                            }
                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    } else {
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

                case 'set_estatus':

                    if (validarPermisos('usuarios.estatus')) {
                        if (!empty($_POST['id'])) {
                            $id = $_POST['id'];
                            $response = $controller->setEstatus($id);
                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    } else {
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'set_password':

                    if (validarPermisos('usuarios.reset')) {
                        if (!empty($_POST['id']) && isset($_POST['password'])) {
                            $id = $_POST['id'];
                            $password = $_POST['password'];
                            $response = $controller->setPassword($id, $password);
                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    } else {
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'update':

                    if (validarPermisos('usuarios.edit')) {
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
                            $response = $controller->update($id, $name, $email, $telefono, $tipo);
                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    } else {
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'delete':

                    if (validarPermisos('usuarios.destroy')) {
                        if (!empty($_POST['id'])) {
                            $id = $_POST['id'];
                            $response = $controller->delete($id);
                        } else {
                            $response = crearResponse('faltan_datos');
                        }
                    } else {
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'get_permisos':

                    if (!empty($_POST['id'])) {

                        $id = $_POST['id'];
                        $response = $controller->edit($id);
                        if (!is_null($response['permisos'])) {
                            $response['user_permisos'] = json_decode($response['permisos']);
                        } else {
                            $response['user_permisos'] = null;
                        }
                        $permisos = verPermisos();
                        $response['permisos'] = $permisos[1];
                        $response['html_permisos'] = $permisos[0];
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'set_permisos':

                    if (validarPermisos()) {

                        if (!empty($_POST['id'])) {

                            $id = $_POST['id'];
                            $contador = $_POST['contador'];
                            $permisos = array();
                            for ($i = 1; $i <= $contador; $i++) {
                                if (isset($_POST['permiso_' . $i])) {
                                    $permiso = $_POST['permiso_' . $i];
                                    $permisos[] = $permiso;
                                }
                            }
                            $response = $controller->setPermisos($id, $permisos);
                        } else {
                            $response = crearResponse('faltas_datos');
                        }

                    } else {
                        $response = crearResponse('no_permisos');
                    }

                    break;

                case 'search':
                    $paginate = true;

                    if (!empty($_POST['keyword'])){
                        $keyword = $_POST['keyword'];
                        $controller->search($keyword);
                        require "../_layout/card_table.php";
                    }else{
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'get_municipios':
                    $modelmunicipio = new municipio();

                    $response = crearResponse(null, true, null, null, 'success', false, true);

                    foreach ($modelmunicipio->getAll() as $municipio) {
                        $id = $municipio['id'];
                        $nombre = $municipio['mini'];
                        $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    foreach ($model->getAll(1) as $user) {
                        $id = $user['id'];
                        $email = $user['email'];
                        $nombre = $user['name'];
                        $response['usuarios'][] = array("id" => $id, "email" => $email, "name" => $nombre);
                    }
                    break;

                case 'get_acceso':
                    $paginate = true;
                    $i = 0;
                    $x = 0;
                    $limit = 1;
                    $listarUsuarios = $model->paginate($limit, null, 'id', 'DESC', 1, 'acceso_municipio', '!=', 'null');
                    $links = paginate('_request/UsersRequest.php', 'usuario_table_acceso', $limit, $model->count(1, 'acceso_municipio', '!=', 'null'), null, 'paginate_acceso', 'usuario_card_table_acceso', '_acceso')->createLinks();
                    require '../_layout/card_table_acceso.php';
                    break;

            //Por defecto
        default:
            $response = crearResponse('no_opcion', false, null, $opcion);
            break;
        }

        }
catch
    (PDOException $e) {
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
