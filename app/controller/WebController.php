<?php

namespace app\controller;

use app\middleware\Auth;

class WebController extends Auth
{
    public function isAdmin()
    {
        if ($this->USER_ROLE) {
            header('location: '. ROOT_PATH.'admin\\');
        }
    }
}