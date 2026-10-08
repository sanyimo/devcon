<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public string $email;
    public string $name;
    public string $token;
    
    public function __construct(string $email, string $name, string $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation() {

         // create a new object
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->Port = $_ENV['EMAIL_PORT'];
         $mail->Username = $_ENV['EMAIL_USER'];
         $mail->Password = $_ENV['EMAIL_PASS'];
     
         $mail->setFrom('cuentas@devwebcamp.com');
         $mail->addAddress($this->email, $this->name);
         $mail->Subject = 'Confirma tu Cuenta';

         // Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $content = '<html>';
         $content .= "<p><strong>Hola " . $this->name .  "</strong> Has registrado correctamente tu cuenta en DevCon pero es necesario confirmarla.</p>";
         $content .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a>";       
         $content .= "<p>Si tú no creaste esta cuenta, puedes ignorar el mensaje.</p>";
         $content .= '</html>';
         $mail->Body = $content;

         //Enviar el mail
         $mail->send();

    }

    public function sendInstructions() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('cuentas@devwebcamp.com');
        $mail->addAddress($this->email, $this->name);
        $mail->Subject = 'Restablece tu contraseña';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';
        $content .= "<p><strong>Hola " . $this->name .  "</strong> Has solicitado restablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>";
        $content .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/restore?token=" . $this->token . "'>Restablecer contraseña</a>";        
        $content .= "<p>Si tú no solicitaste este cambio, puedes ignorar el mensaje.</p>";
        $content .= '</html>';
        $mail->Body = $content;

        //send mail
        $mail->send();
    }
}