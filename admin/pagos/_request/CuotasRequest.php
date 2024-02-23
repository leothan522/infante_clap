<?php
session_start();
require_once "../../../vendor/autoload.php";

use app\controller\PagosController;
use app\model\Cuota;
use app\model\Municipio;
use app\model\Parametros;

$controller = new PagosController();

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {
            $model = new Cuota();
            $modelParametros = new Parametros();
            switch ($opcion) {

                //definimos las opciones a procesar
                case 'paginate':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';
                    $campo = !empty($_POST['campo']) ? $_POST['campo'] : '';
                    $operador = !empty($_POST['operador']) ? $_POST['operador'] : '';
                    $valor = !empty($_POST['valor']) ? $_POST['valor'] : '';

                    $listarCuotas = $model->paginate(
                        $limit,
                        $offset,
                        'fecha',
                        'DESC',
                        1,
                        $campo,
                        $operador,
                        $valor);
                    $links = paginate(
                        '_request/CuotasRequest.php',
                        'tabla_cuotas',
                        $limit,
                        $model->count(1, $campo, $operador, $valor),
                        $offset,
                        'paginate',
                        'card_body_cuotas',
                        null,
                        $campo,
                        $operador,
                        $valor
                    )->createLinks();
                    $i = $offset;

                    require '../_layout/table_cuotas.php';

                    break;

                case 'guardar_cuotas':
                    if (
                        !empty($_POST['cuotas_select_mes']) &&
                        !empty($_POST['cuotas_input_fecha'] &&
                        !empty($_POST['municipios_id'])
                        )
                    ){
                        $mes = $_POST['cuotas_select_mes'];
                        $fecha = $_POST['cuotas_input_fecha'];
                        $municipios_id = $_POST['municipios_id'];
                        $precio = $_POST['cuotas_input_precio'];
                        $adicional = $_POST['cuotas_input_adicional'];
                        $year = date("Y");



                        $existe = false;
                        $error_mes = false;
                        $error_fecha = false;

                        $sql = "SELECT * FROM `cuotas` WHERE `mes` = '$mes' AND `year` = '$year' AND municipios_id = $municipios_id;";
                        $existeCuota = $model->sqlPersonalizado($sql);

                        if ($existeCuota){
                            $existe = true;
                            $error_mes = true;
                        }


                        $listarCuotas = $model->getAll(1, 'fecha', 'DESC');
                        if ($listarCuotas){
                            foreach ($listarCuotas as $cuota){
                                $db_fecha = $cuota['fecha'];
                                break;
                            }
                            if ($fecha < $db_fecha){
                                $existe = true;
                                $error_fecha = true;
                            }
                        }

                        if (empty($precio)){
                            $precio = NULL;
                        }else{
                            $precio = $_POST['cuotas_input_precio'];
                        }

                        if (empty($adicional)){
                            $adicional = NULL;
                        }else{
                            $adicional = $_POST['cuotas_input_adicional'];
                        }

                        if (!$existe){
                            $data = [
                                $mes,
                                $fecha,
                                $precio,
                                $adicional,
                                $municipios_id,
                                $year
                            ];

                            $model->save($data);

                            $sql = "SELECT * FROM parametros WHERE nombre = 'precio_modulo' AND tabla_id = '$municipios_id';  ";
                            $parametro = $modelParametros->sqlPersonalizado($sql);
                            if ($parametro){
                                if ($precio != $parametro['valor']){
                                    $modelParametros->update($parametro['id'], 'precio_modulo', $precio);
                                }
                            }else{
                                $dataParametros = [
                                    'precio_modulo',
                                    $municipios_id,
                                    $precio
                                ];
                                $modelParametros->save($dataParametros);
                            }


                            $response = crearResponse(
                                false,
                                true,
                                'Guardado Exitosamente',
                                'Se Guardo Exitosamente'
                            );
                            $cuota = $model->first('mes', '=', $mes);
                            $response['id'] = $cuota['id'];
                            $response['mes'] = mesEspanol($cuota['mes']);
                            $response['fecha'] = '<p class="text-center"> ' . verFecha($cuota['fecha']) . ' </p>';
                            $response['item'] = '<p class="text-center"> ' . $model->count(1) . '. </p>';
                            $response['nuevo'] = true;
                            $response['total'] = $model->count(1);
                        }else{

                            $response = crearResponse(
                                null,
                                false,
                                'JS',
                                'JS',
                                'warning',
                                false,
                                true
                            );

                            $response['error_mes'] = false;
                            $response['error_fecha'] = false;
                            if ($error_mes){ $response['error_mes'] = true; }
                            if ($error_fecha){ $response['error_fecha'] = true; }

                        }



                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_cuotas':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $cuota = $model->find($id);
                        $response = crearResponse(
                            false,
                            true,
                            'Editar Cuota',
                            'Editar Cuota',
                            'success',
                            false,
                            true
                        );
                        $response['mes'] = $cuota['mes'];
                        $response['fecha'] = $cuota['fecha'];
                        $response['precio'] = $cuota['precio'];
                        $response['adicional'] = $cuota['adicional'];
                        $response['id'] = $cuota['id'];

                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'editar_cuotas':
                    if (
                        !empty($_POST['cuotas_select_mes']) &&
                        !empty($_POST['cuotas_input_fecha']) &&
                        !empty($_POST['cuotas_id'])
                    ){
                        $mes = $_POST['cuotas_select_mes'];
                        $fecha = $_POST['cuotas_input_fecha'];
                        $precio = $_POST['cuotas_input_precio'];
                        $adicional = $_POST['cuotas_input_adicional'];
                        $id = $_POST['cuotas_id'];
                        $cambios = false;
                        $cuota = $model->find($id);

                        $db_mes = $cuota['mes'];
                        $db_fecha = $cuota['fecha'];
                        $db_precio = $cuota['precio'];
                        $db_adicional = $cuota['adicional'];

                        if ($db_mes != $mes){
                            $cambios = true;
                            $model->update($id, 'mes', $mes);
                        }

                        if ($db_fecha != $fecha){
                            $cambios = true;
                            $model->update($id, 'fecha', $fecha);
                        }

                        if ($db_precio != $precio){
                            $cambios = true;
                            $model->update($id, 'precio', $precio);
                        }

                        if ($db_adicional != $adicional){
                            $cambios = true;
                            $model->update($id, 'adicional', $adicional);
                        }

                        if ($cambios){
                            $response = crearResponse(
                                false,
                                true,
                                'Editado Exitosamente',
                                'Editado Exitosamente'
                            );
                            $cuota = $model->find($id);
                            $response['id'] = $cuota['id'];
                            $response['mes'] = mesEspanol($cuota['mes']);
                            $response['fecha'] = '<p class="text-center"> ' . verFecha($cuota['fecha']) . ' </p>';
                            $response['item'] = '<p class="text-center"> ' . $model->count(1) . '. </p>';
                            $response['nuevo'] = false;
                            $response['total'] = $model->count(1);

                        }else{
                            $response = crearResponse('no_cambios');
                        }

                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'eliminar_cuotas':

                    if (
                        !empty($_POST['id'])
                    ) {

                        //proceso
                        $id = $_POST['id'];
                        $model->delete($id);

                        $response = crearResponse(
                            null,
                            true,
                            'Cuota Eliminada.',
                            'Cuota Eliminada.'
                        );
                        $response['total'] = $model->count(1);


                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'getPrecio':
                    if (empty($_POST['id'])){
                        $id = -1;
                    }else{
                        $id = $_POST['id'];
                    }
                    $sql = "SELECT * FROM parametros WHERE nombre = 'precio_modulo' AND tabla_id = '$id';  ";
                    $parametro = $modelParametros->sqlPersonalizado($sql);
                    $response = crearResponse(
                        null,
                        true,
                        null,
                        null,
                        'success',
                        null,
                        true
                    );
                    if ($parametro){
                        $response['precio_modulo'] = $parametro['valor'];
                    }else{
                        $response['precio_modulo'] = null;
                    }
                    break;

                case 'get_municipios':
                    $model = new Municipio();

                    $response = crearResponse(null, true, null, null, 'success', false, true);

                    foreach ($model->getAll() as $municipio) {
                        $id = $municipio['id'];
                        $nombre = $municipio['mini'];
                        if (validarAccesoMunicipio($id)){
                            $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                        }
                    }
                    break;

                case 'listar_cuotas':
                    $paginate = true;

                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];

                        $limit = numRowsPaginate();

                        $listarCuotas = $model->paginate($limit, null, 'fecha', 'DESC', 1, 'municipios_id', '=', $id);
                        $links = paginate(
                            '_request/CuotasRequest.php',
                            'tabla_cuotas',
                            $limit,
                            $model->count(1, 'municipios_id', '=', $id),
                            null,
                            'paginate',
                            'card_body_cuotas',
                            null,
                            'municipios_id',
                            '=',
                            $id)->createLinks();
                        $i = 0;

                        require '../_layout/table_cuotas.php';


                    }else{
                        echo '<div class="card-body"><span>Seleccione un Municipio para empezar</span></div>';
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

if (!$paginate) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
