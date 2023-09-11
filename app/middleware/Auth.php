<?php
namespace app\middleware;

use app\model\User;
use PDOException;
use Exception;

class Auth
{

    public mixed $USER_ID;
    public mixed $USER_NAME;
    public mixed $USER_EMAIL;
    public mixed $USER_PASSWORD;
    public mixed $USER_TELEFONO;
    public mixed $USER_TOKEN;
    public mixed $USER_PATH;
    public mixed $USER_ROLE;
    public mixed $USER_ROLE_ID;
    public mixed $USER_PERMISOS;
    public mixed $USER_STATUS;
    public mixed $USER_BAND;
    public mixed $USER_DISPOSITIVO;
    public mixed $USER_CREATED_AT;
    
    public function __construct($index = false)
    {
        if (isset($_SESSION['id'])) {
            
            try {
                
                $user = new User();
                $getUser = $user->find($_SESSION['id']);
                $this->USER_ID = $getUser['id'];
                $this->USER_NAME = $getUser['name'];
                $this->USER_EMAIL = $getUser['email'];
                $this->USER_PASSWORD = $getUser['password'];
                $this->USER_TELEFONO = $getUser['telefono'];
                $this->USER_TOKEN = $getUser['token'];
                $this->USER_PATH = $getUser['path'];
                $this->USER_ROLE = $getUser['role'];
                $this->USER_ROLE_ID = $getUser['role_id'];
                $this->USER_PERMISOS = $getUser['permisos'];
                $this->USER_STATUS = $getUser['estatus'];
                $this->USER_BAND = $getUser['band'];
                $this->USER_DISPOSITIVO = $getUser['dispositivo'];
                $this->USER_CREATED_AT = $getUser['created_at'];

                if (!$this->USER_BAND) {
                    session_destroy();
                    header('location: '. ROOT_PATH. 'login\\');
                }
                
            } catch (PDOException $e) {
                session_destroy();
                header('location: '. ROOT_PATH. 'login\\'); 
            }

        } else {
            if (!$index) {
                session_destroy();
                header('location: '. ROOT_PATH. 'login\\');
            }
        }
        
    }


}