<?php

require_once ("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require_once ("vendor/phpmailer/phpmailer/src/Exception.php");
require_once ("vendor/phpmailer/phpmailer/src/SMTP.php");
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 

date_default_timezone_set('America/Argentina/Buenos_aires');
 

/*
        prop.put("mail.smtp.host", "smtp.gmail.com");
        prop.put("mail.smtp.port", "587");
        prop.put("mail.smtp.auth", "true");
        prop.put("mail.smtp.starttls.enable", "true"); //TLS
        prop.put("mail.smtp.ssl.trust", "smtp.gmail.com");
		
		*/


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

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return true;

        }

