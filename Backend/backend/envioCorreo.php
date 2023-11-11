<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../librerias_externas/phpmailer/src/Exception.php';
require '../librerias_externas/phpmailer/src/PHPMailer.php';
require '../librerias_externas/phpmailer/src/SMTP.php';
require 'formulario.php';

// $documento = $_FILES['pdfCotizacion'];
// $folioCotizacion = $_POST['folioCotizacion'];
$fechaMovimiento = date('Y/m/d');

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 1;                      //Enable verbose debug outpu   
    $mail->isSMTP();                                         //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = 'login';                                   //Enable SMTP authentication
    $mail->Username   = '';                     //correo
    $mail->Password   = '';                               //contraseña
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('no-reply@segared.com', 'segared');
    $mail->addAddress('sistemas.cyes9@gmail.com');     //correo a enviar
   

    // //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Importante';
    $mail->Body    = 'Prueba';


    $mail->send();
    echo 'Message ENVIADO';
} catch (Exception $e) {
    echo "ERROR EN, Mailer Error: {$mail->ErrorInfo}";
}



?>