<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv as Dotenv;

$dotenv = Dotenv::createImmutable('../includes/.env');
$dotenv->safeLoad();

class Email {
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = '465';
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'luigivalentino9912@gmail.com';
        $mail->Password = 'akdgqegicygkvpkq';

        $mail->addAddress($_POST['email']);
        $mail->setFrom('luigivalentino9912@gmail.com');
        $mail->Subject = 'Confirma tu Cuenta';

        //Set HTMLL
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en UpTask, ahora debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='https://uptaskapp-56sis.ondigitalocean.app/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si no has sido tu quien solicito esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones() {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = '465';
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'luigivalentino9912@gmail.com';
        $mail->Password = 'akdgqegicygkvpkq';
        // $mail->Port = $_ENV['MAIL_PORT'];
        // $mail->Host = $_ENV['MAIL_HOST'];
        // $mail->Username = $_ENV['MAIL_USER'];
        // $mail->Password = $_ENV['MAIL_PASSWORD'];

        $mail->addAddress($_POST['email']);
        $mail->setFrom('luigivalentino9912@gmail.com');
        $mail->Subject = 'Reestablece tu Password';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='https://uptaskapp-56sis.ondigitalocean.app/reestablecer?token=" . $this->token . "'>Reestablecer Cuenta</a></p>";
        $contenido .= "<p>Si no has sido tu quien solicito este cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }
}