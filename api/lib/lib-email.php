<?php
//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './lib/PHPMailer.php';
require './lib/Exception.php';
require './lib/SMTP.php';

function enviaemail($para, $nombre, $asunto, $cuerpo) {

    $nombre = utf8_decode($nombre);
    $asunto = utf8_decode($asunto);
    $cuerpo = utf8_decode($cuerpo);

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer;

    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;              // Enable verbose debug output
    // $mail->SMTPDebug = 2;              // Enable verbose debug output
    $mail->isSMTP();                                    // Send using SMTP
    $mail->Host       = 'smtp.office365.com';           // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                           // Enable SMTP authentication
    $mail->SMTPKeepAlive = true;                        // SMTP connection will not close after each email sent
    $mail->Username   = 'embajador@myyezz.com';             // SMTP username
    $mail->Password   = 'Xud52447';                     // SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption;
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption;
    $mail->Port       = 587;                            // TCP port to connect to, use 465 for 

    //Recipients
    $mail->setFrom('embajador@myyezz.com', utf8_decode('Embajadores Yezz'));
    $mail->addAddress($para, $nombre); // Add a recipient
    // $mail->addAddress('ellen@example.com');                 // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    return $mail->send();
    // if (!$mail->send()) {
    //     echo "falló<br/>";
    //     // return false;
    // } else {
    //     echo "envió<br/>";
    //     // return true;
    // }
}

function enviaemailconadjuntos($para, $nombre, $asunto, $cuerpo, $adjuntos) {
    $nombre = utf8_decode($nombre);
    $asunto = utf8_decode($asunto);
    $cuerpo = utf8_decode($cuerpo);

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer;

    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;              // Enable verbose debug output
    // $mail->SMTPDebug = 2;              // Enable verbose debug output
    $mail->isSMTP();                                    // Send using SMTP
    $mail->Host       = 'smtp.office365.com';           // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                           // Enable SMTP authentication
    $mail->SMTPKeepAlive = true;                        // SMTP connection will not close after each email sent
    $mail->Username   = 'credi@popclik.com';             // SMTP username
    $mail->Password   = 'Guw07587';                     // SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption;
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption;
    $mail->Port       = 587;                            // TCP port to connect to, use 465 for 

    //Recipients
    $mail->setFrom('embajador@myyezz.com', utf8_decode('Embajadores Yezz'));
    $mail->addAddress($para, $nombre); // Add a recipient
    // $mail->addAddress('ellen@example.com');                 // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    foreach($adjuntos as $archivo) {
        // var_dump($archivo);
        $mail->addAttachment($archivo["tmp_name"], $archivo["name"]);    // Optional name
    }
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    return $mail->send();
    // if (!$mail->send()) {
    //     echo "falló<br/>";
    //     // return false;
    // } else {
    //     echo "envió<br/>";
    //     // return true;
    // }
}


function popclikemailcondeclaracion($para, $nombre, $asunto, $cuerpo) {
    $nombre = utf8_decode($nombre);
    $asunto = utf8_decode($asunto);
    $cuerpo = utf8_decode($cuerpo);

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer;

    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;              // Enable verbose debug output
    // $mail->SMTPDebug = 2;              // Enable verbose debug output
    $mail->isSMTP();                                    // Send using SMTP
    $mail->Host       = 'smtp.office365.com';           // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                           // Enable SMTP authentication
    $mail->SMTPKeepAlive = true;                        // SMTP connection will not close after each email sent
    $mail->Username   = 'credi@popclik.com';             // SMTP username
    $mail->Password   = 'Guw07587';                     // SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption;
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption;
    $mail->Port       = 587;                            // TCP port to connect to, use 465 for 

    //Recipients
    $mail->setFrom('embajador@myyezz.com', utf8_decode('Embajadores Yezz'));
    $mail->addAddress($para, $nombre); // Add a recipient
    // $mail->addAddress('ellen@example.com');                 // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    $archivo = 'Declaracion_Jurada_de_Ingresos.pdf';
    $mail->AddAttachment($archivo,$archivo);
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    return $mail->send();
    // if (!$mail->send()) {
    //     echo "falló<br/>";
    //     // return false;
    // } else {
    //     echo "envió<br/>";
    //     // return true;
    // }
}
?>