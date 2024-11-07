<?php
session_start();
require_once 'db.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado como cliente
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener el usuario de la sesión
$usuario = $_SESSION['usuario'];

// Consultar información del cliente usando el usuario en sesión
$query = "SELECT idCliente, nombreCliente, apellidoCliente FROM cliente WHERE usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

if (!$cliente) {
    echo "No se encontró información del cliente.";
    exit();
}

// Obtener el ID del cliente para el pedido
$idCliente = $cliente['idCliente'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hacer un Pedido</title>
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
        .order-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        /* Título */
        .order-container h2 {
            color: #333333;
            text-align: center;
            margin-bottom: 1rem;
        }

        /* Información del cliente */
        .order-container p {
            color: #555555;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        /* Etiquetas y campos de entrada */
        .order-container label {
            display: block;
            color: #555555;
            font-weight: bold;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .order-container input[type="text"],
        .order-container input[type="date"],
        .order-container input[type="number"],
        .order-container select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        /* Botón de enviar */
        .order-container button {
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

        .order-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="order-container">
        <h2>Formulario de Pedido</h2>
        <p>Cliente: <?php echo $cliente['nombreCliente'] . " " . $cliente['apellidoCliente']; ?></p>
        <form action="guardar_pedido.php" method="POST">
            <input type="hidden" name="idCliente" value="<?php echo $idCliente; ?>">

            <label for="idTipoTrabajo">Tipo de Trabajo:</label>
            <select id="idTipoTrabajo" name="idTipoTrabajo" required>
                <?php
                // Obtener y mostrar tipos de trabajo disponibles en la base de datos
                $tiposQuery = "SELECT idTipoTrabajo, descripcion FROM tipotrabajo";
                $tiposResult = $conexion->query($tiposQuery);
                while ($tipo = $tiposResult->fetch_assoc()) {
                    echo "<option value='" . $tipo['idTipoTrabajo'] . "'>" . $tipo['descripcion'] . "</option>";
                }
                ?>
            </select>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="presupuesto">Presupuesto:</label>
            <input type="number" id="presupuesto" name="presupuesto" step="0.01" required>

            <button type="submit">Hacer Pedido</button>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar conexión y liberar recursos
$stmt->close();
$conexion->close();
?>
