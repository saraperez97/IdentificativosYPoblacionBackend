<?php
// encabezados de respuesta
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Configuración de la base de datos
$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "basededatos";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Manejar solicitudes HTTP
?>
