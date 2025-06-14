<?php
session_start();
include 'conexion.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE EMAIL = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    if (password_verify($password, $fila['PASSWORD'])) {
        // Login exitoso: guardamos datos y mensaje
        $_SESSION['usuario_id'] = $fila['ID_USER'];
        $_SESSION['usuario_nombre'] = $fila['NOMBRE'];
        $_SESSION['mensaje_exito'] = "Has iniciado sesión correctamente.";

        header("Location: index.php");
        exit();
    } else {
        header("Location: iniciar_sesion.php?error=1");
        exit();
    }
} else {
    header("Location: iniciar_sesion.php?error=2");
    exit();
}
?>
