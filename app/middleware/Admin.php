<?php
namespace app\middleware;

class Admin extends Auth
{
    public function isAdmin()
    {
        if (!$this->USER_ROLE) {
            header('location: '. ROOT_PATH.'web\\');
        }
    }
}