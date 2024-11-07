<?php 
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "zipcomguatemala";

// Conectar a la base de datos
$conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Si todo es correcto, la conexión está lista para ser usada
//echo "Conexión exitosa a la base de datos.";
?>
