<?php
session_start();
require_once('db.php'); 

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Código</title>
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
        .verify-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Título */
        .verify-container h2 {
            color: #333333;
            margin-bottom: 1rem;
        }

        /* Etiquetas y campos de entrada */
        .verify-container label {
            display: block;
            text-align: left;
            color: #555555;
            font-weight: bold;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .verify-container input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        /* Botón de enviar */
        .verify-container button {
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

        .verify-container button:hover {
            background-color: #45a049;
        }

        /* Mensaje de error */
        .error-message {
            color: red;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="verify-container">
        <h2>Verificación de Código 2FA</h2>
        <form action="verificar_codigo.php" method="POST">
            <label for="codigo">Introduce el código de 4 dígitos:</label>
            <input type="text" id="codigo" name="codigo" maxlength="4" required><br><br>
            
            <button type="submit" name="verificar">Verificar</button>
        </form>

        <?php
        if (isset($_POST['verificar'])) {
            $codigo_ingresado = $_POST['codigo'];

            // Verificar si el código ingresado coincide con el de la sesión
            if ($codigo_ingresado == $_SESSION['codigo_2fa']) {
                // Obtener el rol del usuario
                $usuario = $_SESSION['usuario'];
                $query = "SELECT idTipoUsuario FROM usuario WHERE usuario = ?";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param("s", $usuario);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if ($user['idTipoUsuario'] == 1) {
                    // Redirigir a la página de administrador
                    header("Location: admin_page.php");
                } elseif ($user['idTipoUsuario'] == 2) {
                    // Redirigir a la página de cliente
                    header("Location: cliente_page.php");
                }
                exit();
            } else {
                echo "<p class='error-message'>Código incorrecto. Inténtalo de nuevo.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
