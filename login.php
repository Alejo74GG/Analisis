<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        /* Estilo general */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
        }

        /* Contenedor del formulario */
        .login-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Título */
        .login-container h2 {
            color: #333333;
            margin-bottom: 1rem;
        }

        /* Etiquetas y campos de entrada */
        .login-container label {
            display: block;
            text-align: left;
            color: #555555;
            font-weight: bold;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        /* Botón de enviar */
        .login-container button {
            margin-top: 1.5rem;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            color: #ffffff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #45a049;
        }

        /* Espacio entre los campos */
        .form-field {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <div class="form-field">
                <label for="usuario">Nombre de Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="form-field">
                <label for="clave">Contraseña:</label>
                <input type="password" id="clave" name="clave" required>
            </div>
            <button type="submit" name="login">Iniciar Sesión</button>
        </form>
    </div>
</body>

</html>

<?php
// Código PHP de autenticación permanece igual
if (isset($_POST['login'])) {
    require_once('db.php'); // Tu conexión a la base de datos

    // Capturar las credenciales del formulario
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $clave = mysqli_real_escape_string($conexion, $_POST['clave']);

    // Consulta para verificar si el usuario existe
    $query = "SELECT * FROM usuario WHERE usuario='$usuario'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verificar que la contraseña coincida
        if ($clave == $user['clave']) {
            // Credenciales correctas, generar el código de 4 dígitos
            $codigo = rand(1000, 9999);

            // Guardar el código en la sesión
            $_SESSION['codigo_2fa'] = $codigo;
            $_SESSION['usuario'] = $usuario;

            // Enviar el código al correo electrónico
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
                $mail->SMTPAuth = true;
                $mail->Username = 'jcochojilh@miumg.edu.gt'; // Tu correo de Gmail
                $mail->Password = 'MascarillaVerde15'; // Contraseña de Gmail o App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Configuración del correo
                $mail->setFrom('tu_correo@gmail.com', 'Nombre');
                $mail->addAddress($user['usuario']); // Correo del destinatario (del usuario autenticado)

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Código de Verificación 2FA';
                $mail->Body    = "Tu código de verificación es: $codigo";

                // Enviar el correo
                $mail->send();

                // Redirigir a la pantalla de verificación de código
                header("Location: verificar_codigo.php");
                exit();
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            // Si la contraseña no coincide
            echo "Usuario o contraseña incorrectos.";
        }
    } else {
        // Si el usuario no existe
        echo "No existe una cuenta con este usuario.";
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
