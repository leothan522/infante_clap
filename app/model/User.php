<?php
namespace app\model;

use app\model\Model;

class User extends Model
{
    public function __construct()
    {
        $this->TABLA = "users";
        $this->DATA = [
            'name',
            'email',
            'password',
            'telefono',
            'role',
            'created_at'
        ];
    }
}