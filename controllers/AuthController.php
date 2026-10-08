<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class AuthController {
    public static function login(Router $router) {

        $alerts = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $user = new User($_POST);

            $alerts = $user->validateLogin();
            
            if(empty($alerts)) {
                // Verificar quel el usuario exista
                $user = User::where('email', $user->email);
                if(!$user || !$user->confirmed ) {
                    User::setAlert('error', 'El usuario no existe o no está confirmado');
                } else {
                    // El Usuario existe
                    if( password_verify($_POST['password'], $user->password) ) {
                        
                        // Iniciar la sesión
                        session_start();    
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['surname'] = $user->surname;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['admin'] = $user->admin ?? null;

                        // Redirección 
                        if($user->admin) {
                            header('Location: /admin/dashboard');
                        } else {
                            header('Location: /finish-record');
                        }
                        
                    } else {
                        User::setAlert('error', 'Contraseña incorrecta');
                    }
                }
            }
        }

        $alerts = User::getAlerts();
        
        // Render a la vista 
        $router->render('auth/login', [
            'title' => 'Iniciar sesión',
            'alerts' => $alerts
        ]);
    }

    public static function logout() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
       
    }

    public static function record(Router $router) {
        $alerts = [];
        $user = new User;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user->syncronize($_POST);
            
            $alerts = $user->validate_account();

            if(empty($alerts)) {
                $userExists = User::where('email', $user->email);

                if($userExists) {
                    User::setAlert('error', 'Este usuario ya está registrado');
                    $alerts = User::getAlerts();
                } else {
                    // Hashear el password
                    $user->hashPassword();

                    // Eliminar password2
                    unset($user->password2);

                    // Generar el Token
                    $user->createToken();

                    // Crear un nuevo usuario
                    $result =  $user->save();

                    // Enviar email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendConfirmation();
                    

                    if($result) {
                        header('Location: /message');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/record', [
            'title' => 'Crea tu cuenta en DevCon',
            'user' => $user, 
            'alerts' => $alerts
        ]);
    }

    public static function forgot(Router $router) {
        $alerts = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alerts = $user->validateEmail();

            if(empty($alerts)) {
                // Buscar el usuario
                $user = User::where('email', $user->email);

                if($user && $user->confirmed) {

                    // Generar un nuevo token
                    $user->createToken();
                    unset($user->password2);

                    // Actualizar el usuario
                    $user->save();

                    // Enviar el email
                    $email = new Email( $user->email, $user->name, $user->token );
                    $email->sendInstructions();


                    // Imprimir la alerta
                    // User::setAlert('exito', 'Hemos enviado las instrucciones a tu email');

                    $alerts['exito'][] = 'Hemos enviado las instrucciones a tu email';
                } else {

                    // User::setAlert('error', 'El Usuario no existe o no esta confirmado');

                    $alerts['error'][] = 'El Usuario no existe o no está confirmado';
                }
            }
        }

        // Muestra la vista
        $router->render('auth/forgot', [
            'title' => 'He olvidado mi contraseña',
            'alerts' => $alerts
        ]);
    }

    public static function restore(Router $router) {

        $token = s($_GET['token']);

        $token_valid = true;

        if(!$token) header('Location: /');

        // Identificar el usuario con este token
        $user = User::where('token', $token);

        if(empty($user)) {
            User::setAlert('error', 'Token no válido, intenta de nuevo');
            $token_valid = false;
        }


        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Añadir el nuevo password
            $user->syncronize($_POST);

            // Validar el password
            $alerts = $user->validatePassword();

            if(empty($alerts)) {
                // Hashear el nuevo password
                $user->hashPassword();

                // Eliminar el Token
                $user->token = null;

                // Guardar el usuario en la BD
                $result = $user->save();

                // Redireccionar
                if($result) {
                    header('Location: /login');
                }
            }
        }

        $alerts = User::getAlerts();
        
        // Muestra la vista
        $router->render('auth/restore', [
            'title' => 'Restablecer contraseña',
            'alerts' => $alerts,
            'token_valid' => $token_valid
        ]);
    }

    public static function message(Router $router) {

        $router->render('auth/message', [
            'title' => 'Cuenta creada con éxito'
        ]);
    }

    public static function confirm(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $user = User::where('token', $token);

        if(empty($user)) {
            // No se encontró un usuario con ese token
            User::setAlert('error', 'Token no válido, la cuenta no se ha confirmado');
        } else {
            // Confirmar la cuenta
            $user->confirmed = 1;
            $user->token = '';
            unset($user->password2);
            
            // Guardar en la BD
            $user->save();

            User::setAlert('exito', 'Éxito, cuenta confirmada');
        }

     

        $router->render('auth/confirm', [
            'title' => 'Confirma tu cuenta DevCon',
            'alerts' => User::getAlerts()
        ]);
    }
}