<?php
header('Content-Type: text/html; charset=utf-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar campos
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $proyecto = $_POST['proyecto'] ?? '';
    $asunto = $_POST['asunto'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';
    $privacidad = isset($_POST['privacidad']) ? 'Aceptada' : 'No aceptada';

    if (empty($nombre) || empty($correo) || empty($telefono) || empty($proyecto) || empty($asunto) || empty($mensaje)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Cambiar a DEBUG_OFF en producción
        $mail->isSMTP();
        $mail->Host = 'mail.edgecloud.com.mx'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'contacto@edgecloud.com.mx'; 
        $mail->Password = 'Operaciones1'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Configuración del remitente y destinatario
        $mail->setFrom('contacto@edgecloud.com.mx', 'EDGE & CLOUD');
        $mail->addAddress('contacto@edgecloud.com.mx'); 

        // Codificación en UTF-8
        $mail->CharSet = 'UTF-8';

        // Asunto y cuerpo del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = "
            <p><strong>Nombre:</strong> $nombre</p>
            <p><strong>Correo:</strong> $correo</p>
            <p><strong>Teléfono:</strong> $telefono</p>
            <p><strong>Proyecto:</strong> $proyecto</p>
            <p><strong>Mensaje:</strong></p>
            <p>$mensaje</p>
        ";

        // Enviar correo
        $mail->send();
        echo "Mensaje enviado correctamente.";
        header('Location: ./contact.html?success=1');
        exit;
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
    }
}
?>
