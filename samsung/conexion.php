<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "samsung";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "";
}
?>