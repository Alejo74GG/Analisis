<?php

// Configurar la respuesta JSON
header('Content-Type: application/json');

// Capturar el JSON de entrada
$requestPayload = file_get_contents('php://input');
$requestData = json_decode($requestPayload, true);

// Verificar si se ha recibido el mensaje
if (!isset($requestData['message']) || empty($requestData['message'])) {
    echo json_encode(['message' => '¡Ups! No entendí lo que dijiste. ¿Podrías intentarlo de nuevo?']);
    exit();
}

// Extraer el mensaje
$incomingMessage = strtolower($requestData['message']);
$responseMessage = '';

// Responder con un tono más casual según las palabras clave
if (preg_match('/.*hola.*/i', $incomingMessage)) {
    $responseMessage = '¡Hola! ¿Cómo estás? ¿En qué puedo ayudarte hoy? 😊';
} elseif (preg_match('/.*horario.*/i', $incomingMessage)) {
    $responseMessage = 'Estamos abiertos de 8:00 a.m. a 8:00 p.m. ¡Te esperamos!';
} elseif (preg_match('/.*envio.*/i', $incomingMessage)) {
    $responseMessage = '¡Claro! Ofrecemos envío gratuito a todos los departamentos. 📦';
} elseif (preg_match('/.*productos.*disponibles.*/i', $incomingMessage)) {
    $responseMessage = 'Nuestros productos están en la tienda, y puedes ver el stock en tiempo real. ¡Echa un vistazo! 🛒';
} elseif (preg_match('/.*ayuda.*/i', $incomingMessage)) {
    $responseMessage = 'Estoy aquí para ayudarte. Puedes preguntar sobre nuestros productos, horarios o cualquier otra cosa que necesites. 😊';
} elseif (preg_match('/.*información.*/i', $incomingMessage)) {
    $responseMessage = 'Si necesitas ayuda con un pedido, escríbenos a correo o llama al telefono. 📞';
} elseif (preg_match('/.*chiste.*/i', $incomingMessage)) {
    $responseMessage = '¡Claro! ¿Por qué la bicicleta no pudo parar? Porque estaba dos-tada. 😄';
} else {
    $responseMessage = "Mmm... No estoy seguro de qué necesitas. 😅 ";
    $responseMessage .= 'Prueba preguntándome sobre nuestros horarios, envíos o productos. ¡Estoy aquí para ayudarte!';
}

// Enviar la respuesta como JSON
echo json_encode(['message' => $responseMessage]);
