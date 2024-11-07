<?php
session_start();
require_once 'db.php'; // Archivo de conexión a la base de datos

// Verificar si el usuario está autenticado como administrador
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se recibió el ID del pedido
if (isset($_POST['idPedido'])) {
    $idPedido = $_POST['idPedido'];

    // Actualizar el estado del pedido a "terminado"
    $query = "UPDATE pedido SET estado = 1 WHERE idPedido = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $idPedido);

    if ($stmt->execute()) {
        header("Location: admin_page.php");
        exit();
    } else {
        echo "Error al actualizar el estado del pedido: " . $conexion->error;
    }
}
?>
