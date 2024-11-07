<?php
session_start();
require_once 'db.php'; // Conexión a la base de datos

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = $_POST['idCliente'];
    $idTipoTrabajo = $_POST['idTipoTrabajo'];
    $fecha = $_POST['fecha'];
    $direccion = $_POST['direccion'];
    $presupuesto = $_POST['presupuesto'];

    // Insertar el pedido en la base de datos con estado "pendiente" (0)
    $query = "INSERT INTO pedido (idCliente, idTipoTrabajo, fecha, direccion, presupuesto, estado) VALUES (?, ?, ?, ?, ?, 0)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("iissd", $idCliente, $idTipoTrabajo, $fecha, $direccion, $presupuesto);

    if ($stmt->execute()) {
        echo "Pedido registrado exitosamente.";
        header("Location: cliente_page.php"); // Redirige de vuelta a cliente_page.php después de guardar
        exit();
    } else {
        echo "Error al registrar el pedido: " . $conexion->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
}
?>
