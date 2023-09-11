<?php
namespace app\database;
use app\database\Conexion;

class Query extends Conexion
{

    public function getFirst($sql): mixed
    {
        $statement = $this->CONEXION->prepare($sql);
        $statement->execute();
        $row = $statement->fetch();
        return $row;

    }

    public function getAll($sql): array
    {
        $statement = $this->CONEXION->prepare($sql);
        $statement->execute();
        $rows = array();
        while($result = $statement->fetch()){
            array_push($rows, $result);
        }
        return $rows;
    }

    public function save($sql): bool|\PDOStatement
    {
       $statement = $this->CONEXION->prepare($sql);
       $statement->execute();
       return $statement;
    }

    public function count($sql): mixed
    {
        $statement = $this->CONEXION->prepare($sql);
        $statement->execute();
        $count = $statement->fetchColumn();
        return $count;
    }

}