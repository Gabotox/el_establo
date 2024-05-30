<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PhPMailer/src/PHPMailer.php';
require '../PhPMailer/src/SMTP.php';
require '../PhPMailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF; // Corregir aquí
    $mail->isSMTP();
    $mail->Host       = MAIL_HOST; // Cambia según tu proveedor de correo  "smtp.gmail.com"
    $mail->SMTPAuth   = true;
    $mail->Username   = MAIL_USER;
    $mail->Password   = MAIL_PASS; // Cambia por tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = MAIL_PORT;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom(MAIL_USER, 'El establo');
    $mail->addAddress('anjodivi15@gmail.com', 'Joe User');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Detalle de su compra';
    $cuerpo = '<h4>Gracias por su compra</h4>'; 
    $cuerpo .= '<p>El id de su compra es <b>'.$id_transaccion.'</b></p>';
    $mail->Body = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra';
    $mail->setLanguage('es', '../PhPMailer/language/phpmailer.lang-es.php');

    $mail->send();
   
} catch (Exception $e) {
    echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
}

?>
