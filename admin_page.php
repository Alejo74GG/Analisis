<?php
session_start();
require_once 'db.php'; // Archivo de conexión a la base de datos

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Consultar todos los pedidos en la base de datos
$query = "SELECT p.idPedido, p.fecha, p.direccion, p.presupuesto, p.estado, c.nombreCliente, c.apellidoCliente
          FROM pedido p
          INNER JOIN cliente c ON p.idCliente = c.idCliente";
$result = $conexion->query($query);

if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de Pedidos</title>
    <style>
        /* Estilo general */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        /* Título */
        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Estilos de la tabla */
        table {
            width: 90%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Botones */
        .btn {
            padding: 8px 12px;
            color: #ffffff;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn.disabled {
            background-color: #999999;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h2>Administración de Pedidos</h2>
    <table>
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Dirección</th>
                <th>Presupuesto</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['idPedido']; ?></td>
                    <td><?php echo $row['nombreCliente'] . " " . $row['apellidoCliente']; ?></td>
                    <td><?php echo $row['fecha']; ?></td>
                    <td><?php echo $row['direccion']; ?></td>
                    <td><?php echo "$" . number_format($row['presupuesto'], 2); ?></td>
                    <td><?php echo ($row['estado'] == 1) ? "Terminado" : "Pendiente"; ?></td>
                    <td>
                        <?php if ($row['estado'] == 0): ?>
                            <form action="cambiar_estado.php" method="POST">
                                <input type="hidden" name="idPedido" value="<?php echo $row['idPedido']; ?>">
                                <button type="submit" class="btn">Marcar como Terminado</button>
                            </form>
                        <?php else: ?>
                            <button class="btn disabled" disabled>Terminado</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Liberar los resultados y cerrar la conexión
$result->free();
$conexion->close();
?>
