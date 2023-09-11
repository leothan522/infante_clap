<?php

namespace app\controller;
use app\model\User;
class RecoverController
{
    public $token;
    public $email;
    public function __construct()
    {
        if (isset($_SESSION['id'])){
            header('location:'. ROOT_PATH.'admin\\');
        }

        if (isset($_GET['token']) && isset($_GET['email'])){


            $token = $_GET['token'];
            $email = $_GET['email'];
            $model = new User();
           $existeEmail = $model->existe('email', '=', $email,null,1);

           if ($existeEmail){
            $db_token = $existeEmail['token'];
            $db_date_token = $existeEmail['date_token'];
            $id = $existeEmail['id'];
            $hoy = date("Y-m-d H:i:s");
            $this->token = compararFechas($db_date_token, $hoy);

            if (compararFechas($db_date_token, $hoy) == 0){
                if ($token == $db_token){
                $this->token = $token;
                }else{
                    header('location:'. ROOT_PATH.'login\\');
                }

            }else{
                $model->update($id, 'date_token', null);
                $model->update($id, 'token', null);
                header('location:'. ROOT_PATH.'login\\');
            }



           }else{
               header('location:'. ROOT_PATH.'login\\');
           }
        }else{
            header('location:'. ROOT_PATH.'login\\');
        }
    }

}