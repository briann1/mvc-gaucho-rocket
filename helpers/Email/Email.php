<?php
/*
require_once ("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require_once ("vendor/phpmailer/phpmailer/src/Exception.php");
require_once ("vendor/phpmailer/phpmailer/src/SMTP.php");
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('America/Argentina/Buenos_aires');
 */
 
use PHPMailer\PHPMailer\PHPMailer;

class Email{
 
 
    public function enviarEmail($email, $clave){
  
   
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

//Crear una instancia de PHPMailer
$mail = new PHPMailer();
//Definir que vamos a usar SMTP
$mail->IsSMTP();
//Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
// 0 = off (producción)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug  = 2;
//Ahora definimos gmail como servidor que aloja nuestro SMTP
$mail->Host       = 'smtp.gmail.com';
//El puerto será el 587 ya que usamos encriptación TLS
$mail->Port       = 587;
//Definmos la seguridad como TLS
$mail->SMTPSecure = 'tls';
//Tenemos que usar gmail autenticados, así que esto a TRUE
$mail->SMTPAuth   = true;
//Definimos la cuenta que vamos a usar. Dirección completa de la misma
$mail->Username   = "systemenergym@gmail.com";
//Introducimos nuestra contraseña de gmail
$mail->Password   = "okjrszxdvlfbaodu";
//Definimos el remitente (dirección y, opcionalmente, nombre)
$mail->SetFrom('systemenergym@gmail.com', 'Elece Ayala');
//Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
$mail->AddAddress('correodedestino@dominio.com', 'El Destinatario');
//Definimos el tema del email
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Esto es un correo de prueba';
//Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
//$mail->MsgHTML(file_get_contents('correomaquetado.html'), dirname(ruta_al_archivo));
//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
$mail->Body = 'Por favor ingrese al siguiente link para poder verificar su cuenta';
$mail->AltBody = 'This is a plain-text message body';
//Enviamos el correo
if(!$mail->Send()) {
echo "Error: " . $mail->ErrorInfo;
} else {
echo "Enviado!";
}




/*

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
		$mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
         $mail->SMTPAuth = true;
        $mail->Username = "systemenergym@gmail.com";
        $mail->Password = "okjrszxdvlfbaodu";
        //Recipients
        $mail->setFrom('systemenergym@gmail.com', 'Mauro Ayala');
        $mail->addAddress("mauro.julian.ayala@gmail.com");

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Activa tu cuenta Transporte La Matanza';
        $messege = '</br>
            Gracias por registrarte!</br>
            Tu cuenta ha sido creada, activala utilizando el enlace de la parte inferior.</br>
            </br>
            ------------------------</br>
            Username:  </br>
            ------------------------</br>
             </br>
            Por favor haz clic en este enlace para activar tu cuenta:</br>
            http://localhost/login/activarUsuario?email=asd
            
            ';
        $mail->msgHTML($messege);

        $mail->AltBody = $messege;

        $mail->send();
*/

	
    }
 
}