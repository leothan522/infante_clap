<?php
namespace app\model;

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
            'role_id',
            'permisos',
            'created_at'
        ];
    }
}