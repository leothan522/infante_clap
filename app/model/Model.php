<?php
namespace app\model;
use app\database\Query;
class Model
{
    public $TABLA;
    public $DATA;

    public function getAll($band = null, $orderBy = null, $opt ='ASC'): array
    {
        $extra = null;
        $order = null;
        if (!is_null($band)) {
            $extra = "WHERE `band`= $band";
        }
        if (!is_null($orderBy)) {
            $order = "ORDER BY `$orderBy` $opt";
        }
        $query = new Query();
        $sql = "SELECT * FROM `$this->TABLA` $extra  $order;";
        $rows = $query->getAll($sql);
        return $rows;
    }

    public function paginate($limit, $offset = null, $orderBy = 'id', $opt = 'ASC', $band = null, $campo = null, $operador = null, $valor = null): array
    {
        $extra = null;
        $where = null;
        $columna = null;
        if (!is_null($band)) {
            $where = true;
            $extra = "`band`= $band";
        }
        if (!is_null($offset)){
            $offset = $offset.",";
        }

        if (!is_null($campo) && !is_null($operador) && !is_null($valor)){
            $where = true;
            if (!is_null($extra)){
                $columna = "`$campo` $operador '$valor' AND";
            }else{
                $columna = "`$campo` $operador '$valor'";
            }
        }

        if (!is_null($where)){
            $where = 'WHERE ';
        }

        $query = new Query();
        $sql = "SELECT * FROM `$this->TABLA`  $where $columna $extra ORDER BY `$orderBy` $opt LIMIT $offset $limit;";
        $rows = $query->getAll($sql);
        return $rows;
    }

    public function getList($campo, $operador, $valor, $band = null, $orderBy = null, $opt ='ASC'): array
    {
        $extra = null;
        $order = null;
        if (!is_null($band)) {
            $extra = "AND `band`= $band";
        }
        if (!is_null($orderBy)) {
            $order = "ORDER BY `$orderBy` $opt";
        }
        $query = new Query();
        $sql = "SELECT * FROM `$this->TABLA` WHERE `$campo` $operador '$valor' $extra $order; ";
        $rows = $query->getAll($sql);
        return $rows;
    }

    public function count($band = null): mixed
    {
        $extra = null;
        if (!is_null($band)) {
            $extra = "WHERE `band`= $band";
        }
        $query = new Query();
        $sql = "SELECT COUNT(*) FROM `$this->TABLA` $extra ;";
        $rows = $query->count($sql);
        return $rows;
    }

    public function find($id): mixed
    {
        $query = new Query();
        $sql = "SELECT * FROM `$this->TABLA` WHERE `id`= '$id'; ";
        $rows = $query->getfirst($sql);
        return $rows;
    }

    public function first($campo, $operador, $valor): mixed
    {
        $query = new Query();
        $sql = "SELECT * FROM `$this->TABLA` WHERE `$campo` $operador '$valor'; ";
        $rows = $query->getfirst($sql);
        return $rows;
    }

    public function existe($campo, $operador, $valor, $id = null, $band = null): mixed
    {
        $extra = null;
        $edit = null;
        if ($band) {
            $extra = "AND `band`= $band";
        }
        if ($id) {
            $edit = "AND `id` != '$id'";
        }
        $query = new Query();
        $sql = "SELECT * FROM `$this->TABLA` WHERE `$campo` $operador '$valor' $extra $edit;";
        $row = $query->getFirst($sql);
        return $row;
    }

    public function save($data = array()): bool|\PDOStatement
    {
        $query = new Query();
        $campos = "(";
        foreach ($this->DATA as $campo) {
            $campos .= "`$campo`, ";
        }
        $campos .= ")exit";
        $campos = str_replace(", )exit", ")", $campos);
        $values = "(";
        foreach ($data as $input) {
            if (is_null($input)){
                $values .= "NULL, ";
            }else{
                $values .= "'$input', ";
            }
        }
        $values .= ")exit";
        $values = str_replace(", )exit", ")", $values);

        $sql = "INSERT INTO `$this->TABLA` $campos VALUES $values;";

        $row = $query->save($sql);
        return $row;
    }

    public function update($id, $campo, $valor): bool|\PDOStatement
    {
        if (is_null($valor)){
            $values = 'NULL';
        }else{
            $values = "'$valor'";
        }
        $query = new Query();
        $sql = "UPDATE `$this->TABLA` SET `$campo` = $values WHERE `id` = '$id';";
        $row = $query->save($sql);
        return $row;
    }

    public function delete($id): bool|\PDOStatement
    {
        $query = new Query();
        $sql = "DELETE FROM `$this->TABLA` WHERE  `id` = $id;";
        $row = $query->save($sql);
        return $row;
    }

}