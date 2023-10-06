<?php
session_start();
require_once "../../vendor/autoload.php";

use app\model\Clap;
use app\model\Municipio;
use app\model\Bloque;
use app\model\Parroquia;
use app\model\Ente;
use app\model\Jefe;

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {
            $model = new Clap();
            switch ($opcion) {

                //definimos las opciones a procesar

                case 'get_municipios_select':
                    $modelMunicipio = new Municipio();

                    $response = crearResponse(
                        null,
                        true,
                        'Exito.',
                        'Exito.',
                        'success',
                        false,
                        true
                    );

                    $response['municipios'] = array();
                    foreach ($modelMunicipio->getAll() as $municipio) {
                        $id = $municipio['id'];
                        $nombre = $municipio['mini'];
                        $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    $modelEnte = new Ente();
                    $response['entes'] = array();
                    foreach ($modelEnte->getAll(null, 'nombre') as $ente) {
                        $id = $ente['id'];
                        $nombre = $ente['nombre'];
                        $response['entes'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    break;

                case 'get_bloque_parroquia':
                    if (!empty($_POST['id'])) {
                        $municipio_id = $_POST['id'];

                        $response = crearResponse(
                            null,
                            true,
                            'Exito.',
                            'Exito.',
                            'success',
                            false,
                            true
                        );

                        $modelBloque = new Bloque();
                        $response['bloques'] = array();
                        foreach ($modelBloque->getList('municipios_id', '=', $municipio_id, null, 'numero') as $bloque) {
                            $id = $bloque['id'];
                            $nombre = $bloque['numero'];
                            $response['bloques'][] = array("id" => $id, "nombre" => $nombre);
                        }

                        $modelParroquia = new Parroquia();
                        $response['parroquias'] = array();
                        foreach ($modelParroquia->getList('municipios_id', '=', $municipio_id) as $parroquia) {
                            $id = $parroquia['id'];
                            $nombre = $parroquia['nombre'];
                            $response['parroquias'][] = array("id" => $id, "nombre" => $nombre);
                        }

                    } else {
                        $response['result'] = crearResponse('faltan_datos');
                    }
                    break;

                case 'guardar_clap':
                    if (
                        !empty($_POST['clap_select_municipio']) &&
                        !empty($_POST['clap_select_parroquia']) &&
                        !empty($_POST['clap_select_bloque']) &&
                        !empty($_POST['clap_select_estracto']) &&
                        !empty($_POST['clap_input_nombre']) &&
                        !empty($_POST['clap_input_familias']) &&
                        !empty($_POST['clap_select_entes']) &&
                        !empty($_POST['jefe_input_cedula']) &&
                        !empty($_POST['jefe_input_nombre']) &&
                        !empty($_POST['jefe_select_genero']) &&
                        !empty($_POST['jefe_input_telefono'])
                    ){
                        $municipio = $_POST['clap_select_municipio'];
                        $parroquia = $_POST['clap_select_parroquia'];
                        $bloque = $_POST['clap_select_bloque'];
                        $estracto = $_POST['clap_select_estracto'];
                        $clap_nombre = $_POST['clap_input_nombre'];
                        $familias = $_POST['clap_input_familias'];
                        $entes = $_POST['clap_select_entes'];
                        $cedula = $_POST['jefe_input_cedula'];
                        $jefe_nombre = $_POST['jefe_input_nombre'];
                        $genero = $_POST['jefe_select_genero'];
                        $telefono = $_POST['jefe_input_telefono'];
                        $ubch = $_POST['clap_ubch'];
                        $email = $_POST['jefe_input_email'];

                        $sql = "SELECT * FROM `claps` WHERE `municipios_id` = '$municipio' AND `nombre` = '$clap_nombre';";
                        $existeClap = $model->sqlPersonalizado($sql);
                        $modelJefe = new Jefe();
                        $existejefe = $modelJefe->existe('cedula', '=', $cedula);

                        if (empty($ubch)){
                            $ubch = null;
                        }

                        if (!$existeClap && !$existejefe){
                            //proceso
                            $data = [
                                $clap_nombre,
                                $estracto,
                                $familias,
                                $municipio,
                                $parroquia,
                                $bloque,
                                $entes,
                                $ubch
                            ];

                            $model->save($data);
                            $sql = "SELECT * FROM `claps` WHERE `municipios_id` = '$municipio' AND `nombre` = '$clap_nombre';";
                            $clapNuevo = $model->sqlPersonalizado($sql);
                            if ($clapNuevo){

                                if (empty($email)){
                                    $email = null;
                                }

                                $data = [
                                    $cedula,
                                    $jefe_nombre,
                                    $telefono,
                                    $genero,
                                    $email,
                                    $clapNuevo['id']
                                ];

                                $modelJefe->save($data);

                            }
                            $jefeNuevo = $modelJefe->existe('cedula', '=', $cedula, null, 1);

                            $response = crearResponse(
                              null,
                              true,
                              'Guardado Exitosamente.',
                              'El Clap se ha guardado Exitosamente.'
                            );
                            $response['nombre_clap'] = $clapNuevo['nombre'];
                            $response['nombre_jefe'] = $jefeNuevo['nombre'];
                            $response['cedula'] = $jefeNuevo['cedula'];
                            $response['telefono'] = $jefeNuevo['telefono'];
                            $response['familias'] = $clapNuevo['familias'];
                            $response['nuevo'] = true;

                        }else{
                            //dulicado
                            $response = crearResponse(
                                'datos_duplicados',
                                false,
                                'Datos Duplicados',
                                'Datos Duplicados',
                                'warning'
                            );

                            $response['error_clap'] = false;
                            $response['error_jefe'] = false;
                            $response['message_clap'] = null;
                            $response['message_jefe'] = null;

                            if ($existeClap){
                                $response['error_clap'] = true;
                                $response['message_clap'] = 'El nombre del Clap ya se encuentra registrado en el municipio';
                            }

                            if ($existejefe){
                                $response['error_jefe'] = true;
                                $response['message_jefe'] = 'La cédula ya se encuentra registrada';
                            }

                        }

                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_datos_clap':
                   if (!empty($_POST['id'])) {
                       $id = $_POST['id'];
                       $response = crearResponse(
                           null,
                           true,
                           'Datos del CLAP',
                           'Datos del CLAP',
                           'success',
                           null,
                           true
                       );
                       $clap = $model->find($id);

                       $response['estracto'] = $clap['estracto'];
                       $response['nombre'] = $clap['nombre'];
                       $response['familias'] = $clap['familias'];
                       $response['ubch'] = $clap['ubch'];

                   }else{
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
