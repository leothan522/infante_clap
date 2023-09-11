<?php

namespace app\controller;

class GuestController
{
    public function __construct()
    {
        if (isset($_SESSION['id'])){
            header('location:'. ROOT_PATH.'admin\\');
        }
    }
}