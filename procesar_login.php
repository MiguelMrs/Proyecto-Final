<?php
session_start();
include 'conexion.php'; // tu conexión a la base de datos

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE EMAIL = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    if (password_verify($password, $fila['PASSWORD'])) {
        $_SESSION['usuario_id'] = $fila['ID_USER'];
        $_SESSION['usuario_nombre'] = $fila['NOMBRE']; // << ESTE CAMPO SE USA EN EL HEADER
        header("Location: index.php");
        exit();
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "Correo no encontrado";
}
?>
