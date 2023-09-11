<?php
session_start();
require_once "../vendor/autoload.php";
session_destroy();
header('location: '. ROOT_PATH.'login\\');
