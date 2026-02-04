<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$nombre  = trim($data['nombre'] ?? '');
$asunto  = trim($data['asunto'] ?? '');
$mensaje = trim($data['mensaje'] ?? '');

if ($nombre === '' || $asunto === '' || $mensaje === '') {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

$para = "contacto@laserdiller.com";
$subject = "Formulario de contacto: $asunto";

$body  = "Nombre: $nombre\n";
$body .= "Asunto: $asunto\n\n";
$body .= "Mensaje:\n$mensaje";

$headers = "From: LaserDiller Web <no-reply@laserdiller.com>\r\n";
$headers .= "Reply-To: contacto@laserdiller.com\r\n";

if (mail($para, $subject, $body, $headers)) {
    echo json_encode(["ok" => true]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo enviar el correo"]);
}
