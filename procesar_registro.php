<?php
session_start();
require 'conexion.php';

// Recoger datos del formulario
$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validaciones básicas
if ($password !== $confirm_password) {
    echo "❌ Las contraseñas no coinciden.";
    exit();
}

// Verificar si el correo ya existe
$sql = "SELECT ID_USER FROM usuarios WHERE EMAIL = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "⚠️ Este correo ya está registrado.";
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Hashear la contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar nuevo usuario
$sql_insert = "INSERT INTO usuarios (NOMBRE, EMAIL, PASSWORD, FECHA_REGISTRO) VALUES (?, ?, ?, CURDATE())";
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("sss", $nombre, $email, $password_hash);

if ($stmt->execute()) {
    // Registro exitoso: redirige a la página de login o inicia sesión automáticamente
    header("Location: iniciar_sesion.php?registro=exitoso");
    exit();
} else {
    echo "❌ Error al registrar el usuario: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
