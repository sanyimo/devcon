<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public string $email;
    public string $name;
    public string $token;
    public string $language;
    
    public function __construct(string $email, string $name, string $token, string $language)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
        $this->language = $language;
    }

    public function sendConfirmation() {

         // Create a new object
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         $mail->Port = $_ENV['EMAIL_PORT'];
         $mail->Username = $_ENV['EMAIL_USER'];
         $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom($_ENV['EMAIL_USER'], 'DevCon');
         $mail->addAddress($this->email, $this->name);
         $mail->Subject = $this->language === 'en' ? 'Confirm your account' : 'Confirma tu Cuenta';

        // Set HTML
        $content = '<!DOCTYPE html>';
        $content .= '<html lang="' . ($this->language === 'en' ? 'en' : 'es') . '">';
        $content .= '<body>';
        $content .= $this->language === 'en'
            ? '<p><strong>Hello ' . htmlspecialchars($this->name) . '</strong></p>
       <p>You have successfully registered your DevCon account, but you need to confirm it.</p>
       <p><a href="' . $_ENV['HOST'] . '/confirm-account?token=' . $this->token . '">Confirm account</a></p>
       <p>If you did not create this account, you can ignore this message.</p>'
            : '<p><strong>Hola ' . htmlspecialchars($this->name) . '</strong></p>
       <p>Has registrado correctamente tu cuenta en DevCon, pero es necesario confirmarla.</p>
       <p><a href="' . $_ENV['HOST'] . '/confirm-account?token=' . $this->token . '">Confirmar cuenta</a></p>
       <p>Si tú no creaste esta cuenta, puedes ignorar este mensaje.</p>';
        $content .= '</body>';
        $content .= '</html>';

        $mail->Body = $content;

         // Send the email
         $mail->send();

    }

    public function sendInstructions() {

        // Create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom($_ENV['EMAIL_USER'], 'DevCon');
        $mail->addAddress($this->email, $this->name);
        $mail->Subject = $this->language === 'en' ? 'Reset your password' : 'Restablece tu contraseña';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<!DOCTYPE html>';
        $content .= '<html lang="' . ($this->language === 'en' ? 'en' : 'es') . '">';
        $content .= '<body>';
        $content .= $this->language === 'en'
            ? '<p><strong>Hello ' . htmlspecialchars($this->name) . '</strong></p>
       <p>You have requested to reset your password. Follow the link below to do so.</p>
       <p><a href="' . $_ENV['HOST'] . '/restore?token=' . $this->token . '">Reset your password</a></p>
       <p>If you did not request this change, you can ignore this message.</p>'
            : '<p><strong>Hola ' . htmlspecialchars($this->name) . '</strong></p>
       <p>Has solicitado restablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>
       <p><a href="' . $_ENV['HOST'] . '/restore?token=' . $this->token . '">Restablecer contraseña</a></p>
       <p>Si tú no solicitaste este cambio, puedes ignorar el mensaje.</p>';
        $content .= '</body>';
        $content .= '</html>';

        $mail->Body = $content;

        // Send the email
        $mail->send();
    }
}