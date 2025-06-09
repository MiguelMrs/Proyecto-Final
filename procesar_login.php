<?php
session_start(); // Inicia la sesión para poder guardar datos del usuario si el login es exitoso
include 'conexion.php'; // Incluye el archivo para conectar con la base de datos

// Recoge los datos enviados por el formulario POST (email y contraseña)
$email = $_POST['email'];
$password = $_POST['password'];

// Prepara una consulta SQL para buscar un usuario con el email dado
$sql = "SELECT * FROM usuarios WHERE EMAIL = ?";
$stmt = $conn->prepare($sql); // Preparar la sentencia para evitar inyección SQL
$stmt->bind_param("s", $email); // Vincula el parámetro email como string
$stmt->execute(); // Ejecuta la consulta
$resultado = $stmt->get_result(); // Obtiene el resultado de la consulta

// Verifica si se encontró un usuario con ese email
if ($fila = $resultado->fetch_assoc()) {
    // Si existe, verifica que la contraseña introducida coincida con el hash almacenado en la base de datos
    if (password_verify($password, $fila['PASSWORD'])) {
        // Si la contraseña es correcta, guarda datos del usuario en la sesión
        $_SESSION['usuario_id'] = $fila['ID_USER'];
        $_SESSION['usuario_nombre'] = $fila['NOMBRE'];
        header("Location: index.php"); // Redirige a la página principal
        exit(); // Finaliza el script
    } else {
        // Si la contraseña es incorrecta, redirige a la página de login con un error
        header("Location: iniciar_sesion.php?error=1"); // Error: contraseña incorrecta
        exit();
    }
} else {
    // Si no se encuentra un usuario con ese email, redirige con otro error
    header("Location: iniciar_sesion.php?error=2"); // Error: email no encontrado
    exit();
}
?>
