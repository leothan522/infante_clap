<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Cuota;
use app\model\Parametros;

class CuotasController extends Admin
{
    public $links;
    public $rows;
    public $limit;
    public $totalRows;
    public $offset;
    public $keyword;

    public $idMunicipio;

    public function __construct()
    {
        $this->mountMunicipios();
    }

    public function index(
        $idMunicipio,
        $baseURL = '_request/CuotasRequest.php',
        $tableID = 'tabla_cuotas',
        $limit = null,
        $totalRows = null,
        $offset = null
    )
    {
        $model = new Cuota();
        $this->idMunicipio = $idMunicipio;

        if (is_null($limit)) {
            $this->limit = numRowsPaginate();
        } else {
            $this->limit = $limit;
        }
        if (is_null($totalRows)) {
            $this->totalRows = $model->count(1, 'municipios_id', '=', $this->idMunicipio);
        } else {
            $this->totalRows = $totalRows;
        }
        $this->offset = $offset;

        $this->links = paginate(
            $baseURL,
            $tableID,
            $this->limit,
            $this->totalRows,
            $this->offset,
            'paginate',
            'card_body_cuotas',
            null,
            'municipios_id',
            '=',
            $this->idMunicipio
        )->createLinks();

        $this->rows = $model->paginate(
            $this->limit,
            $this->offset,
            'id',
            'DESC',
            1,
            'municipios_id',
            '=',
            $this->idMunicipio
        );
    }

    public function getPrecio($id): array
    {
        $model = new Parametros();
        $sql = "SELECT * FROM parametros WHERE nombre = 'precio_modulo' AND tabla_id = '$id';";
        $parametro = $model->sqlPersonalizado($sql);
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
        return $response;
    }

    public function store($mes, $fecha, $precio, $adicional, $municipios_id): array
    {
        $model = new Cuota();
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

            $modelParametros = new Parametros();
            $sql = "SELECT * FROM parametros WHERE nombre = 'precio_modulo' AND tabla_id = '$municipios_id';  ";
            $parametro = $modelParametros->sqlPersonalizado($sql);
            if ($parametro){
                if ($precio != $parametro['valor']){
                    $modelParametros->update($parametro['id'], 'valor', $precio);
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

        return $response;
    }

    public function edit($id): array
    {
        $model = new Cuota();
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
        return $response;
    }

    public function update($id, $mes, $fecha, $precio, $adicional)
    {
        $model = new Cuota();
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

        return $response;
    }

    public function delete($id)
    {
        $model = new Cuota();
        $model->delete($id);

        $response = crearResponse(
            null,
            true,
            'Cuota Eliminada.',
            'Cuota Eliminada.'
        );
        $response['total'] = $model->count(1);
        return $response;
    }

}