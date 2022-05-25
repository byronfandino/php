<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;

class LoginController{
    public static function login(Router $router){
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Admin($_POST);
            $errores = $auth->validar();

            if (empty($errores)){

                //Verificar si el usuario existe
                $resultado = $auth->existeUsuario();

                /*Cuando el usuario no existe se almacena Null en la variable $resultado
                  en caso de ser así agregamos un error */
                if(!$resultado){
                    $errores = Admin::getErrores();
                }else{
                    //En caso de que el usuario si exista
                    //Verificar el password
                    $autenticado = $auth->comprobarPassword($resultado);
                    
                    if($autenticado){
                        //Autenticar al usuario
                        $auth->autenticar();
                    }else{
                        //Si la contraseña no es correcta entonces volvemos a obtener los errores
                        $errores = Admin::getErrores();
                    }

                }
            }


        }

        $router->render('/auth/login', [
            'errores' => $errores
        ]);
    }
    
    public static function logout(Router $router){
        session_start();
        
        $_SESSION = [];

        header('Location: /');
    }
}

?>