<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Cuota;

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {
            $model = new Cuota();
            switch ($opcion) {

                //definimos las opciones a procesar
                case 'paginate':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';

                    $listarCuotas = $model->paginate($limit, $offset, 'fecha', 'DESC', 1);
                    $links = paginate($baseURL, $tableID, $limit, $model->count(1), $offset, 'paginate', 'dataContainerCuotas', )->createLinks();
                    $i = $offset;
                    echo '<div id="dataContainerCuotas">';
                    require "_layout/table_cuotas.php";
                    echo '</div>';
                    break;

                case 'guardar_cuotas':
                    if (
                        !empty($_POST['cuotas_select_mes']) &&
                        !empty($_POST['cuotas_input_fecha'])
                    ){

                        $mes = $_POST['cuotas_select_mes'];
                        $fecha = $_POST['cuotas_input_fecha'];
                        $precio = $_POST['cuotas_input_precio'];
                        $adicional = $_POST['cuotas_input_adicional'];
                        $year = $_POST['cuota_input_year'];

                        $existe = false;
                        $error_mes = false;
                        $error_fecha = false;

                        $sql = "SELECT * FROM `cuotas` WHERE `mes` = '$mes' AND `year` = '$year';";
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
                                $year
                            ];

                            $model->save($data);
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
