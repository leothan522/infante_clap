<?php
session_start();
require_once "../../vendor/autoload.php";

use app\database\Query;
use app\model\Parametros;
use app\controller\ParametrosController;

$controller = new ParametrosController();

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            $model = new Parametros();

            switch ($opcion) {

                //definimos las opciones a procesar

                case 'paginate':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';

                    $listarParametros = $model->paginate($limit, $offset, 'id', 'DESC',);
                    $linksPaginate= paginate($baseURL, $tableID, $limit, $model->count(), $offset, 'paginate', 'dataContainerParametros')->createLinks();
                    $i = $offset;

                    require "_layout/table.php";

                    break;

                case "guardar":
                    $paginate = true;
                    if (!empty($_POST['name'])) {

                        $name = $_POST['name'];
                        $tabla_id = $_POST['tabla_id'];
                        $valor = $_POST['valor'];

                        if (empty($tabla_id)) {
                            if ($tabla_id != 0) {
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

                        $limit = numRowsPaginate();
                        $totalRows = $model->count();
                        $linksPaginate = paginate(
                            'procesar.php',
                            'table_parametros',
                            $limit,
                            $totalRows,
                            null,
                            'paginate',
                            'dataContainerParametros'
                        )->createLinks();
                        $listarParametros = $model->paginate($limit,null, 'id','DESC');
                        $i = 0;

                        require '_layout/table.php';

                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case "get_parametro":

                    if (!empty($_POST['id'])) {

                        $id = $_POST['id'];
                        $row = $model->find($id);

                        $response = crearResponse(
                            null,
                            true,
                            'Editar Parametro.',
                            'Editar Parametro.',
                            'info'
                        );

                        //datos extras para el $response
                        $response['id'] = $row['id'];
                        $response['nombre'] = $row['nombre'];
                        $response['tabla_id'] = $row['tabla_id'];
                        $response['valor'] = $row['valor'];

                    } else {
                        $response = crearResponse('faltan_datos');
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

                            $response = crearResponse(
                                null,
                                true,
                                'Parametro Actualizado.',
                                'Parametro Actualizado.'
                            );

                            //datos extras para el $response
                            $response['id'] = $id;
                            $response['nombre'] = $nombre;
                            $response['tabla_id'] = $tabla_id;
                            $response['valor'] = $valor;

                        } else {
                            $response = crearResponse('no_cambios');
                        }

                    }else{
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case "eliminar":
                    if (!empty($_POST['id'])) {

                        $id = $_POST['id'];

                        $model->delete($id);

                        $response = crearResponse(
                            null,
                            true,
                            'Parametro Borrado.',
                            'Parametro Borrado.'
                        );
                        //datos extras para el $response
                        $response['total'] = $model->count();

                    } else {
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'navbar_buscar':
                    $paginate = true;

                    if (!empty($_POST['keyword'])){
                        $keyword = $_POST['keyword'];

                        $i = 0;
                        $listarParametros = $model->getList('nombre', 'LIKE', "%$keyword%");

                        require_once "_layout/table.php";

                    }else{
                        $response = crearResponse(
                            true,
                            false,
                            'Escriba lo que desea buscar.',
                            'Escriba lo que desea buscar.',
                            'warning',
                            false,
                            true
                        );
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
