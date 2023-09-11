<?php
namespace app\database;
use Dotenv\Dotenv;
use PDO;

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('America/Caracas');

$dotenv = Dotenv::createImmutable(dirname(__FILE__,3));
$dotenv->load();

class Conexion{

    public PDO $CONEXION;
    public function __construct()
    {

        $db_conexion = $_ENV['DB_CONNECTION'];
        $db_host = $_ENV['DB_HOST'];
        $db_port = $_ENV['DB_PORT'];
        $db_database = $_ENV['DB_DATABASE'];
        $db_username = $_ENV['DB_USERNAME'];
        $db_password = $_ENV['DB_PASSWORD'];
        $this->CONEXION = new PDO("$db_conexion:host=$db_host;dbname=$db_database", $db_username, $db_password);
 
    }


}
