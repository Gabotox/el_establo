
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer{

    function EnviarEmail($email, $asunto, $cuerpo){
        require_once '../config/config.php';
        require '../PhPMailer/src/PHPMailer.php';
        require '../PhPMailer/src/SMTP.php';
        require '../PhPMailer/src/Exception.php';
    
        $mail = new PHPMailer(); // Instanciar un objeto PHPMailer
    
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
        
            //correo emisor y nombre
            $mail->setFrom(MAIL_USER, 'El establo');
            //correo receptor y nombre
            $mail->addAddress($email);     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;
            $mail->setLanguage('es', '../PhPMailer/language/phpmailer.lang-es.php');
        
            if($mail->send()){
                return true;
    
            }else{
                return false;
            }
           
        } catch (Exception $e) {
            echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
            return false;
        }
    }
    
}
?>