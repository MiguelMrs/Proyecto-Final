<?php
$servername = "localhost";
$username = "root";
$password = ""; // tu contraseña, si la tienes
$dbname = "cinedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>