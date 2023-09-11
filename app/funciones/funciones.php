<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->load();
define('ROOT_PATH', $_ENV['APP_URL']);

function asset($url): void
{
    echo ROOT_PATH . $url;
}

function public_url($url): string
{
    return ROOT_PATH . $url;
}

function generar_string_aleatorio($largo = 10, $espacio = false): string
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $caracteres = $espacio ? $caracteres . ' ' : $caracteres;
    $string = '';
    for ($i = 0; $i < $largo; $i++) {
        $string .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $string;
}

//Leer JSON
function leerJson($json, $key)
{
    if ($json == null) {
        return null;
    } else {
        $json = $json;
        $json = json_decode($json, true);
        if (array_key_exists($key, $json)) {
            return $json[$key];
        } else {
            return null;
        }
    }
}

//Crear JSON
function crearJson($array): bool|string
{
    $json = array();
    foreach ($array as $key) {
        $json[$key] = true;
    }
    return json_encode($json);
}

// Spinner Cargando
function verCargando(): void
{
    echo '
<div class="overlay-wrapper">
      <div class="overlay d-none ver_spinner_cargando">
          <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
          </div>
      </div>
 </div>
      ';
}

function verEstatusUsuario($estatus, $icon = true): string
{
    if (!$icon) {
        $suspendido = "Suspendido";
        $activado = "Activo";
    } else {
        $suspendido = '<i class="fas fa-user-times"></i>';
        $activado = '<i class="fa fa-user-check"></i>';
    }

    $status = [
        '0' => '<span class="text-danger">' . $suspendido . '</span>',
        '1' => '<span class="text-success">' . $activado . '</span>'/*,
        '2' => '<span class="text-success">Confirmado</span>'*/
    ];
    return $status[$estatus];
}

function verRoleUsuario($role)
{
    $verRole = null;
    switch ($role) {
        case 0:
            $verRole = 'Público';
            break;
        case 99:
            $verRole = 'Administrador';
            break;
        case 100:
            $verRole = 'Root';
            break;
        default:
            $verRole = 'Estandar';
            break;
    }
    return $verRole;
}


//**************************************************************** */

function cerosIzquierda($numero, $cant_ceros): string
{
    $numeroConCeros = str_pad($numero, $cant_ceros, "0", STR_PAD_LEFT);
    return $numeroConCeros;
}

function verHora($hora): string
{
    $newHora = date("g:i a", strtotime($hora));
    return $newHora;
}

function verFecha($fecha): string
{
    $newDate = date("d-m-Y", strtotime($fecha));
    return $newDate;
}

function verFechaLetras($fecha): string
{
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $numero_ES = array("Uno", "Dos", "Tres", "Cuatro", "Cinco", "Seis", "Siete", "Ocho", "Nueve", "Diez", "Once", "Doce", "Trece", "Catorce", "Quince", "Dieciséis", "Diecisiete", "Dieciocho", "Diecinueve", "Veinte", "Veintiuno", "Veintidos", "Veintitres", "Veinticuatro", "Veinticinco", "Veintiseis", "Veintisiete", "Veintiocho", "Veintinueve", "Treinta", "Treinta y Uno");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    //return $nombredia . " " . $numeroDia . " de " . $nombreMes . " de " . $anio;
    return "A los " . strtoupper($numero_ES[$numeroDia - 1]) . " (" . $numeroDia . ") DEL MES DE " . strtoupper($nombreMes) . " DEL AÑO " . $anio . ".";
}

function compararFechas($fechaInicial, $fechaFinal): float
{
    // Declaramos nuestras fechas inicial y final
    //$fechaInicial = date('2023-05-18');
    //$fechaFinal = date('2023-05-19');

    // Las convertimos a segundos
    $fechaInicialSegundos = strtotime($fechaInicial);
    $fechaFinalSegundos = strtotime($fechaFinal);

    // Hacemos las operaciones para calcular los dias entre las dos fechas y mostramos el resultado
    $dias = ($fechaFinalSegundos - $fechaInicialSegundos) / 86400;
    //echo "La diferencia entre la fecha : " . $fechaInicial . " y " . $fechaFinal . " es de: " . round($dias, 0, PHP_ROUND_HALF_UP)  . " dias.";

    //Resultado de los dias de diferencia entre dos fechas

    /*
*   La diferencia entre la fecha : 2022-01-01 y 2023-01-01 es de: 365 dias.
*/
    return round($dias, 0, PHP_ROUND_HALF_UP);
}

function formatoMillares($cantidad, $decimales = 0): string
{
    return number_format($cantidad, $decimales, ',', '.');
}

function validateJSON(string $json): bool
{
    try {
        $test = json_decode($json, null, JSON_THROW_ON_ERROR);
        if (is_object($test)) return true;
        return false;
    } catch (Exception $e) {
        return false;
    }
}


/*
//Comportamiento similar como una redirección HTTP
window.location.replace ("http://es.stackoverflow.com");

//Comportamiento similar como hacer clic en un enlace
window.location.href = "http://es.stackoverflow.com";
*/
