<?php
session_start(); // Inicia la sesión para usar variables de sesión si hace falta en el futuro
require 'conexion.php'; // Incluye el archivo con la conexión a la base de datos

// Recoger y limpiar los datos enviados desde el formulario
$nombre = trim($_POST['nombre']); // Elimina espacios en blanco al inicio y fin
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validaciones básicas: verifica que las contraseñas coincidan
if ($password !== $confirm_password) {
    echo "❌ Las contraseñas no coinciden.";
    exit(); // Termina el script si las contraseñas no coinciden
}

// Verificar si el correo ya existe en la base de datos para evitar duplicados
$sql = "SELECT ID_USER FROM usuarios WHERE EMAIL = ?";
$stmt = $conn->prepare($sql); // Prepara la consulta para evitar inyección SQL
$stmt->bind_param("s", $email); // Vincula el email como parámetro string
$stmt->execute(); // Ejecuta la consulta
$stmt->store_result(); // Guarda el resultado para poder contar filas

if ($stmt->num_rows > 0) {
    // Si ya existe un usuario con ese correo, muestra mensaje y cierra conexiones
    echo "⚠️ Este correo ya está registrado.";
    $stmt->close();
    $conn->close();
    exit(); // Termina el script para que no continúe el registro
}
$stmt->close(); // Cierra el statement para liberar recursos

// Hashear la contraseña para almacenarla segura en la base de datos
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar el nuevo usuario en la tabla usuarios con la fecha actual (CURDATE())
$sql_insert = "INSERT INTO usuarios (NOMBRE, EMAIL, PASSWORD, FECHA_REGISTRO) VALUES (?, ?, ?, CURDATE())";
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("sss", $nombre, $email, $password_hash); // Vincula los parámetros a la consulta

// Ejecutar la inserción y verificar que haya ido bien
if ($stmt->execute()) {
    // Registro exitoso: redirige a la página de login con un parámetro que indica éxito
    header("Location: iniciar_sesion.php?registro=exitoso");
    exit();
} else {
    // Si hubo un error en la inserción, mostrar mensaje con el error
    echo "❌ Error al registrar el usuario: " . $stmt->error;
}

$stmt->close(); // Cierra el statement
$conn->close(); // Cierra la conexión a la base de datos
?>
