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

            function getJefe($id)
            {
                $model = new Jefe();
                $jefe = $model->first('claps_id', '=', $id);
                return $jefe;
            }

            switch ($opcion) {

                //definimos las opciones a procesar

                case 'paginate':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';

                    $listarClap = $model->paginate($limit, $offset, 'id', 'DESC', 1);
                    $links = paginate($baseURL, $tableID, $limit, $model->count(1), $offset, 'paginate', 'dataContainerClap',)->createLinks();
                    $i = $offset;
                    echo '<div id="dataContainerClap">';
                    require "_layout/table_claps.php";
                    echo '</div>';
                    break;

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
                        if (validarAccesoMunicipio($id)) {
                            $response['municipios'][] = array("id" => $id, "nombre" => $nombre);
                        }
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
                    $modelBloque = new Bloque();
                    $modelMunicipio = new Municipio();

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
                    ) {
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


                        if (empty($ubch)) {
                            $ubch = null;
                        }

                        $getBloque = $modelBloque->find($bloque);
                        $getMunicipio = $modelMunicipio->find($municipio);
                        $asignacionMaxima = $getBloque['familias'];
                        $numBloque = $getBloque['numero'];
                        $nombreMunicipio = $getMunicipio['mini'];
                        $getClaps = $model->getList('bloques_id', '=', $bloque);
                        $suma = 0;

                        foreach ($getClaps as $getClap) {
                            $suma = $suma + $getClap['familias'];
                        }

                        $asignacionCargar = $suma + $familias;

                        do {
                            $token = generar_string_aleatorio(30);
                            $exiteToken = $model->existe('token', '=', $token);
                        } while ($exiteToken);


                        if (!$existeClap && !$existejefe && $asignacionMaxima >= $asignacionCargar) {
                            //proceso
                            $data = [
                                $clap_nombre,
                                $estracto,
                                $familias,
                                $municipio,
                                $parroquia,
                                $bloque,
                                $entes,
                                $ubch,
                                $token
                            ];

                            $model->save($data);
                            $sql = "SELECT * FROM `claps` WHERE `municipios_id` = '$municipio' AND `nombre` = '$clap_nombre';";
                            $clapNuevo = $model->sqlPersonalizado($sql);
                            if ($clapNuevo) {

                                if (empty($email)) {
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
                            $response['id'] = $clapNuevo['id'];
                            $response['nombre_clap'] = '<p class="text-uppercase">' . $clapNuevo['nombre'] . '</p>';
                            $response['nombre_jefe'] = '<p class="text-uppercase">' . $jefeNuevo['nombre'] . '</p>';
                            $response['cedula'] = '<p class="text-right">' . formatoMillares($jefeNuevo['cedula'], 0) . '</p>';
                            $response['telefono'] = '<p class="text-center">' . $jefeNuevo['telefono'] . '</p>';
                            $response['familias'] = '<p class="text-right">' . formatoMillares($clapNuevo['familias'], 0) . '</p>';
                            $response['item'] = '<p class="text-center"> ' . $model->count(1) . '. </p>';
                            $response['nuevo'] = true;
                            $response['total'] = $model->count(1);

                        } else {
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
                            $response['revisar_asignacion'] = false;
                            $response['message_clap'] = null;
                            $response['message_jefe'] = null;

                            if ($asignacionMaxima < $asignacionCargar) {
                                $response = crearResponse(
                                    'revisar_asignacion',
                                    false,
                                    'Revisar la Asignacion de Famílias',
                                    'Se ha superado la Asignación de famílias para el Bloque N° ' . $numBloque . ' del Municipio ' . $nombreMunicipio,
                                    'warning',
                                    true,
                                );
                                $response['error_asignacion'] = true;


                            }

                            if ($existeClap) {
                                $response['error_clap'] = true;
                                $response['message_clap'] = 'El nombre del Clap ya se encuentra registrado en el municipio';
                            }

                            if ($existejefe) {
                                $response['error_jefe'] = true;
                                $response['message_jefe'] = 'La cédula ya se encuentra registrada';
                            }


                        }

                    } else {
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
                        $response['nombre'] = $clap['nombre'];
                        $response['estracto'] = $clap['estracto'];
                        $response['familias'] = $clap['familias'];
                        $response['municipios_id'] = $clap['municipios_id'];
                        $response['parroquias_id'] = $clap['parroquias_id'];
                        $response['bloques_id'] = $clap['bloques_id'];
                        $response['entes_id'] = $clap['entes_id'];
                        $response['ubch'] = $clap['ubch'];
                        $response['id'] = $clap['id'];
                        $response['nuevo'] = false;
                    } else {
                        $response = crearResponse('faltan_datos');
                    }

                    break;

                case 'get_datos_jefe':
                    $modelJefe = new Jefe();
                    if (!empty($_POST['id'])) {
                        $id = $_POST['id'];
                        $response = crearResponse(
                            null,
                            true,
                            'Datos del Jefe',
                            'se trajo los datos del jefe',
                            'success',
                            null,
                            true
                        );
                        $jefe = $modelJefe->find($id);
                        $response['id'] = $jefe['id'];
                        $response['cedula'] = $jefe['cedula'];
                        $response['nombre'] = $jefe['nombre'];
                        $response['genero'] = $jefe['genero'];
                        $response['telefono'] = $jefe['telefono'];
                        $response['email'] = $jefe['email'];
                    } else {
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'editar_jefe':
                    $modelJefe = new Jefe();
                    if (
                        !empty($_POST['jefe_edit_input_cedula']) &&
                        !empty($_POST['jefe_edit_input_nombre']) &&
                        !empty($_POST['jefe_edit_select_genero']) &&
                        !empty($_POST['jefe_edit_input_telefono'])
                    ) {
                        $cedula = $_POST['jefe_edit_input_cedula'];
                        $nombre = $_POST['jefe_edit_input_nombre'];
                        $genero = $_POST['jefe_edit_select_genero'];
                        $telefono = $_POST['jefe_edit_input_telefono'];
                        $email = $_POST['jefe_edit_input_email'];
                        $id = $_POST['jefe_edit_id'];
                        $cambios = false;
                        $jefe = $modelJefe->find($id);

                        $db_cedula = $jefe['cedula'];
                        $db_nombre = $jefe['nombre'];
                        $db_genero = $jefe['genero'];
                        $db_telefono = $jefe['telefono'];
                        $db_email = $jefe['email'];

                        $existe = $modelJefe->existe('cedula', '=', $cedula, $id, 1);

                        if (!$existe) {

                            if ($db_cedula != $cedula) {
                                $cambios = true;
                                $modelJefe->update($id, 'cedula', $cedula);
                            }

                            if ($db_nombre != $nombre) {
                                $cambios = true;
                                $modelJefe->update($id, 'nombre', $nombre);
                            }

                            if ($db_genero != $genero) {
                                $cambios = true;
                                $modelJefe->update($id, 'genero', $genero);
                            }

                            if ($db_telefono != $telefono) {
                                $cambios = true;
                                $modelJefe->update($id, 'telefono', $telefono);
                            }

                            if ($db_email != $email) {
                                $cambios = true;
                                $modelJefe->update($id, 'email', $email);
                            }

                            if ($cambios) {
                                $response = crearResponse(
                                    null,
                                    true,
                                    'Editado Exitosamente.',
                                    'El jefe se ha guardado Exitosamente.'
                                );
                                $jefes = $modelJefe->find($id);
                                $claps = $model->first('id', '=', $jefes['claps_id']);
                                $response['id_clap'] = $claps['id'];
                                $response['id_jefe'] = $jefes['id'];
                                $response['nombre_clap'] = '<p class="text-uppercase">' . $claps['nombre'] . '</p>';
                                $response['nombre_jefe'] = '<p class="text-uppercase">' . $jefes['nombre'] . '</p>';
                                $response['cedula'] = '<p class="text-right">' . formatoMillares($jefes['cedula'], 0) . '</p>';
                                $response['telefono'] = '<p class="text-center">' . $jefes['telefono'] . '</p>';
                                $response['familias'] = '<p class="text-right">' . formatoMillares($claps['familias']) . '</p>';
                                $response['item'] = '<p class="text-center"> ' . $model->count(1) . '. </p>';
                                $response['editar_jefe'] = true;

                            } else {
                                $response = crearResponse(
                                    'sin_cambios',
                                    false,
                                    'Sin cambios',
                                    'no se realizó ningun cambio',
                                    'info',
                                    true
                                );
                            }


                        } else {

                            $response = crearResponse(
                                'datos_duplicados',
                                false,
                                'Datos Duplicados',
                                'Datos Duplicados',
                                'warning'
                            );

                            if ($db_cedula = $cedula) {
                                $response = crearResponse(
                                    'datos-duplicados',
                                    false,
                                    'Datos Duplicados',
                                    'La cédula ya se encuentra registrada.',
                                    'warning'
                                );
                                $response['error_cedula'] = true;
                                $response['message_cedula'] = 'La cédula ya se encuentra registrada.';
                            }


                        }

                    } else {
                        $response = crearResponse(
                            "fantan_datos",
                            false,
                            'Faltan datos',
                            'faltan datos',
                            'warning'
                        );
                    }
                    break;

                case 'editar_clap':
                    $modelBloque = new Bloque();
                    $modelMunicipio = new Municipio();
                    if (
                        !empty($_POST['clap_edit_select_municipio']) &&
                        !empty($_POST['clap_edit_select_parroquia']) &&
                        !empty($_POST['clap_edit_select_bloque']) &&
                        !empty($_POST['clap_edit_select_estracto']) &&
                        !empty($_POST['clap_edit_input_nombre']) &&
                        !empty($_POST['clap_edit_input_familias']) &&
                        !empty($_POST['clap_edit_select_entes'])
                    ) {
                        $municipio = $_POST['clap_edit_select_municipio'];
                        $parroquia = $_POST['clap_edit_select_parroquia'];
                        $bloque = $_POST['clap_edit_select_bloque'];
                        $estracto = $_POST['clap_edit_select_estracto'];
                        $nombre = $_POST['clap_edit_input_nombre'];
                        $familias = $_POST['clap_edit_input_familias'];
                        $entes = $_POST['clap_edit_select_entes'];
                        $ubch = $_POST['clap_edit_ubch'];
                        $id = $_POST['clap_edit_id'];
                        $cambios = false;

                        $sql = "SELECT * FROM `claps` WHERE `municipios_id` = '$municipio' AND `nombre` = '$nombre' AND '$id' != `id` ;";
                        $existe = $model->sqlPersonalizado($sql);
                        $clap = $model->find($id);
                        $modelJefe = new Jefe();
                        $jefe = $modelJefe->first('claps_id', '=', $clap['id']);

                        $db_municipio = $clap['municipios_id'];
                        $db_parroquia = $clap['parroquias_id'];
                        $db_bloque = $clap['bloques_id'];
                        $db_estracto = $clap['estracto'];
                        $db_nombre = $clap['nombre'];
                        $db_familias = $clap['familias'];
                        $db_entes = $clap['entes_id'];
                        $db_ubch = $clap['ubch'];
                        $db_id = $clap['id'];

                        $getBloque = $modelBloque->find($bloque);
                        $getMunicipio = $modelMunicipio->find($municipio);
                        $numBloque = $getBloque['numero'];
                        $nombreMunicipio = $getMunicipio['mini'];
                        $asignacionMaxima = $getBloque['familias'];
                        $getClaps = $model->getList('bloques_id', '=', $bloque);
                        $suma = 0;

                        foreach ($getClaps as $getClap) {
                            if ($getClap['id'] != $id) {
                                $suma = $suma + $getClap['familias'];
                            }
                        }

                        $asignacionCargar = $suma + $familias;

                        if (!$existe && $asignacionMaxima >= $asignacionCargar) {

                            if ($db_municipio != $municipio) {
                                $cambios = true;
                                $model->update($id, 'municipios_id', $municipio);
                            }

                            if ($db_parroquia != $parroquia) {
                                $cambios = true;
                                $model->update($id, 'parroquias_id', $parroquia);
                            }

                            if ($db_bloque != $bloque) {
                                $cambios = true;
                                $model->update($id, 'bloques_id', $bloque);
                            }

                            if ($db_estracto != $estracto) {
                                $cambios = true;
                                $model->update($id, 'estracto', $estracto);
                            }

                            if ($db_nombre != $nombre) {
                                $cambios = true;
                                $model->update($id, 'nombre', $nombre);
                            }

                            if ($db_familias != $familias) {
                                $cambios = true;
                                $model->update($id, 'familias', $familias);
                            }


                            if ($db_entes != $entes) {
                                $cambios = true;
                                $model->update($id, 'entes_id', $entes);
                            }

                            if ($db_ubch != $ubch) {
                                $cambios = true;
                                $model->update($id, 'ubch', $ubch);
                            }

                            if ($cambios) {
                                $response = crearResponse(
                                    null,
                                    true,
                                    'Editado Exitosamente.',
                                    'El Clap se ha editado Exitosamente.'
                                );
                                $claps = $model->find($id);
                                $jefes = $modelJefe->first('claps_id', '=', $clap['id']);
                                $response['id'] = $clap['id'];
                                $response['nombre_clap'] = '<p class="text-uppercase">' . $claps['nombre'] . '</p>';
                                $response['nombre_jefe'] = '<p class="text-uppercase">' . $jefes['nombre'] . '</p>';
                                $response['cedula'] = '<p class="text-right">' . formatoMillares($jefes['cedula'], 0) . '</p>';
                                $response['telefono'] = '<p class="text-center">' . $jefes['telefono'] . '</p>';
                                $response['familias'] = '<p class="text-right">' . formatoMillares($claps['familias'], 0) . '</p>';
                                $response['item'] = '<p class="text-center"> ' . $model->count(1) . '. </p>';
                                $response['edit_clap'] = true;
                            } else {
                                $response = crearResponse(
                                    'sin_cambios',
                                    false,
                                    'Sin cambios',
                                    'no se realizó ningun cambio',
                                    'info',
                                    true
                                );
                            }


                        } else {
                            $response = crearResponse(
                                'datos_duplicados',
                                false,
                                'Datos Duplicados',
                                'Datos Duplicados',
                                'warning'
                            );

                            if ($asignacionMaxima < $asignacionCargar) {
                                $response = crearResponse(
                                    'revisar_asignacion',
                                    false,
                                    'Revisar la Asignacion de Famílias',
                                    'Se ha superado la Asignación de famílias para el Bloque N° ' . $numBloque . ' del Municipio ' . $nombreMunicipio,
                                    'warning',
                                    true
                                );
                                $response['error_edit_asignacion'] = true;
                                $response['message_asignacion'] = 'Se ha superado la Asignación de famílias para el Bloque N° ' . $numBloque . ' del Municipio ' . $nombreMunicipio;
                            }
                        }


                    } else {
                        $response = crearResponse(
                            "fantan_datos",
                            false,
                            'Faltan datos',
                            'faltan datos',
                            'warning'
                        );
                    }

                    break;

                case 'eliminar_clap':
                    if (!empty($_POST['id'])) {

                        //proceso
                        $id = $_POST['id'];
                        $response = crearResponse(
                            null,
                            true,
                            'clap Eliminada.',
                            'Clap Eliminado.'
                        );


                        $modelJefe = new Jefe();
                        $response['jefes'] = array();
                        foreach ($modelJefe->getList('claps_id', '=', $id) as $jefe) {
                            $response['jefes'][] = array("id" => $jefe['id']);
                        }
                        $model->delete($id);
                        $modelJefe->delete($id);

                        //datos extras para el $response
                        $response['total'] = $model->count(1);
                        $response['total_jefes'] = $modelJefe->count();

                    } else {
                        $response = crearResponse('faltan_datos');
                    }


                    break;

                case 'show_clap':

                    $modelMunicipio = new Municipio();
                    $modelParroquia = new Parroquia();
                    $modelBloque = new Bloque();
                    $modelEnte = new Ente();
                    $modelJefe = new Jefe();

                    if (!empty($_POST['id'])) {

                        $id = $_POST['id'];
                        $clap = $model->find($id);

                        $municipio = $modelMunicipio->find($clap['municipios_id']);
                        $parroquia = $modelParroquia->find($clap['parroquias_id']);
                        $bloque = $modelBloque->find($clap['bloques_id']);
                        $entes = $modelEnte->find($clap['entes_id']);
                        $jefe = $modelJefe->first('claps_id', '=', $clap['id']);

                        $response = crearResponse(
                            null,
                            true,
                            '',
                            '',
                            'success',
                            false,
                            true
                        );
                        $response['clap_id'] = $clap['id'];
                        $response['clap_nombre'] = $clap['nombre'];
                        $response['clap_estracto'] = $clap['estracto'];
                        $response['clap_familias'] = formatoMillares($clap['familias']);
                        $response['clap_municipio'] = $municipio['mini'];
                        $response['clap_parroquia'] = $parroquia['nombre'];
                        $response['clap_bloque'] = $bloque['numero'];
                        $response['clap_ente'] = $entes['nombre'];
                        $response['clap_ubch'] = $clap['ubch'];
                        $response['jefe_id'] = $jefe['id'];
                        $response['jefe_cedula'] = formatoMillares($jefe['cedula'], 0);
                        $response['jefe_nombre'] = $jefe['nombre'];
                        $response['jefe_telefono'] = $jefe['telefono'];
                        $response['jefe_genero'] = $jefe['genero'];
                        $response['jefe_email'] = $jefe['email'];


                    } else {
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_claps_municipio':

                    $paginate = true;

                    $modelMunicipio = new Municipio();

                    if (!empty($_POST['id'])) {
                        //proceso
                        $id = $_POST['id'];

                        //traer todos los datos del municipio
                        $municipio = $modelMunicipio->find($id);
                        $limit = 30;
                        $i = 0;
                        $links = paginate('procesar_claps.php', 'tabla_claps', $limit, $model->count(1, 'municipios_id', '=', $id), null, 'paginate', 'dataContainerClap')->createLinks();
                        $listarClap = $model->paginate($limit, null, 'id', 'DESC', 1, 'municipios_id', '=', $id);

                        if (!validarPermisos("claps.create")) {
                            $disabled = 'disabled';
                        }else{
                            $disabled = null;
                        }

                        echo '<div class="card-header">';
                        echo      '<h3 class="card-title">Claps Registrados: <strong>'.$municipio['nombre'].'</strong></h3>';
                        echo         '<div class="card-tools">';
                        echo             '<button class="btn btn-tool" data-toggle="modal" onclick="resetClap(\'clap_create_select_municipio\', \'clap_create_select_entes\')" data-target="#modal-claps"'.$disabled.'>';
                        echo                 '<i class="far fa-file-alt"></i> Nuevo';
                        echo             '</button>';
                        echo         '</div>';
                        echo '</div>';
                        echo '<div class="card-body" >';
                                  require "_layout/table_claps.php";
                        echo '</div>';
                        echo '<div class="card-footer clearfix" id="claps_listar_footer">';
                        echo      $links;
                        echo '</div>';
                        verCargando();
                        
                    } else {
                        echo '<div class="card-header">';
                        echo     '<h3 class="card-title">Claps Registrados</h3>';
                        echo         '<div class="card-tools">';
                        echo             '<button class="btn btn-tool" data-toggle="modal" onclick="resetClap(\'clap_create_select_municipio\', \'clap_create_select_entes\')" data-target="#modal-claps" disabled>';
                        echo                 '<i class="far fa-file-alt"></i> Nuevo';
                        echo             '</button>';
                        echo         '</div>';
                        echo '</div>';
                        echo '<div class="card-body" >';
                        echo      'Seleccione un <strong>Municipio</strong> para empezar...';
                        echo '</div>';
                        echo '<div class="card-footer clearfix" id="claps_listar_footer">';
                        echo '</div>';
                        verCargando();

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
