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
                // Check whether the user exists
                $user = User::where('email', $user->email);
                if(!$user || !$user->confirmed ) {
                    User::setAlert('error', t('El usuario no existe o no está confirmado'));
                } else {
                    // The user exists
                    if( password_verify($_POST['password'], $user->password) ) {
                        
                        // Start the session
                        session_start();    
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['surname'] = $user->surname;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['admin'] = $user->admin ?? null;

                        // Redirect
                        if($user->admin) {
                            header('Location: /admin/dashboard');
                        } else {
                            header('Location: /finish-registration');
                        }
                        
                    } else {
                        User::setAlert('error', t('Contraseña incorrecta'));
                    }
                }
            }
        }

        $alerts = User::getAlerts();
        
        // Render the view
        $router->render('auth/login', [
            'title' => t('Iniciar sesión'),
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
                    User::setAlert('error', t('Este usuario ya está registrado'));
                    $alerts = User::getAlerts();
                } else {
                    // Hash the password
                    $user->hashPassword();

                    // Remove password2
                    unset($user->password2);

                    // Generate the token
                    $user->createToken();

                    // Create a new user
                    $result =  $user->save();

                    // Send the email
                    $email = new Email($user->email, $user->name, $user->token, currentLanguage());
                    $email->sendConfirmation();
                    

                    if($result) {
                        header('Location: /message');
                    }
                }
            }
        }

        // Render the view
        $router->render('auth/record', [
            'title' => t('Crea tu cuenta en DevCon'),
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
                // Find the user
                $user = User::where('email', $user->email);

                if($user && $user->confirmed) {

                    // Generate a new token
                    $user->createToken();
                    unset($user->password2);

                    // Update the user
                    $user->save();

                    // Send the email
                    $email = new Email($user->email, $user->name, $user->token, currentLanguage());
                    $email->sendInstructions();


                    // Display the alert
                    // User::setAlert('exito', 'Hemos enviado las instrucciones a tu email');

                    $alerts['exito'][] = t('Hemos enviado las instrucciones a tu email');
                } else {

                    // User::setAlert('error', 'El Usuario no existe o no esta confirmado');

                    $alerts['error'][] = t('El Usuario no existe o no está confirmado');
                }
            }
        }

        // Render the view
        $router->render('auth/forgot', [
            'title' => t('He olvidado mi contraseña'),
            'alerts' => $alerts
        ]);
    }

    public static function restore(Router $router) {

        $token = s($_GET['token']);

        $token_valid = true;

        if(!$token) header('Location: /');

        // Find the user with this token
        $user = User::where('token', $token);

        if(empty($user)) {
            User::setAlert('error', t('Token no válido, intenta de nuevo'));
            $token_valid = false;
        }


        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Add the new password
            $user->syncronize($_POST);

            // Validate the password
            $alerts = $user->validatePassword();

            if(empty($alerts)) {
                // Hash the new password
                $user->hashPassword();

                // Remove the token
                $user->token = null;

                // Save the user to the database
                $result = $user->save();

                // Redirect
                if($result) {
                    header('Location: /login');
                }
            }
        }

        $alerts = User::getAlerts();
        
        // Render the view
        $router->render('auth/restore', [
            'title' => t('Restablecer contraseña'),
            'alerts' => $alerts,
            'token_valid' => $token_valid
        ]);
    }

    public static function message(Router $router) {

        $router->render('auth/message', [
            'title' => t('Cuenta creada con éxito')
        ]);
    }

    public static function confirm(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Find the user with this token
        $user = User::where('token', $token);

        if(empty($user)) {
            // No user was found with that token
            User::setAlert('error', t('Token no válido, la cuenta no se ha confirmado'));
        } else {
            // Confirm the account
            $user->confirmed = 1;
            $user->token = '';
            unset($user->password2);
            
            // Save to the database
            $user->save();

            User::setAlert('exito', t('Éxito, cuenta confirmada'));
        }

     

        $router->render('auth/confirm', [
            'title' => t('Confirma tu cuenta DevCon'),
            'alerts' => User::getAlerts()
        ]);
    }
}