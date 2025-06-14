<?php
session_start(); // Inicia la sesión para manejar variables de sesión si fuera necesario

require 'conexion.php'; // Incluye el archivo que crea la conexión a la base de datos

// Recoge y limpia los datos recibidos desde el formulario, usando trim para eliminar espacios en blanco
// El operador ?? asegura que si no vienen los datos, la variable sea una cadena vacía
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validación básica: comprueba que las dos contraseñas introducidas coincidan
if ($password !== $confirm_password) {
    // Si no coinciden, redirige al formulario de registro con un error indicando la discrepancia
    header("Location: registrar.php?error=password_mismatch");
    exit(); // Termina la ejecución para que no continúe el script
}

// Consulta para verificar si ya existe un usuario con el mismo email (para evitar duplicados)
$sql = "SELECT ID_USER FROM usuarios WHERE EMAIL = ?";
$stmt = $conn->prepare($sql); // Prepara la consulta para evitar inyección SQL
$stmt->bind_param("s", $email); // Asocia el email recibido como parámetro a la consulta
$stmt->execute(); // Ejecuta la consulta
$stmt->store_result(); // Almacena el resultado para poder verificar el número de filas

// Si ya hay un usuario con ese email
if ($stmt->num_rows > 0) {
    $stmt->close(); // Cierra la consulta preparada
    $conn->close(); // Cierra la conexión a la base de datos
    // Redirige al formulario de registro con un error que indica que el usuario ya existe
    header("Location: registrar.php?error=usuario_repetido");
    exit();
}
$stmt->close(); // Cierra la consulta preparada si no hay usuario repetido

// Hashea la contraseña con password_hash para almacenarla de forma segura en la base de datos
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Inserta el nuevo usuario en la tabla usuarios con los datos proporcionados y la fecha actual
$sql_insert = "INSERT INTO usuarios (NOMBRE, EMAIL, PASSWORD, FECHA_REGISTRO) VALUES (?, ?, ?, CURDATE())";
$stmt = $conn->prepare($sql_insert); // Prepara la consulta de inserción
$stmt->bind_param("sss", $nombre, $email, $password_hash); // Asocia los parámetros a la consulta

// Ejecuta la inserción y comprueba si fue exitosa
if ($stmt->execute()) {
    $stmt->close(); // Cierra la consulta
    $conn->close(); // Cierra la conexión
    // Redirige a la página de iniciar sesión con mensaje de registro exitoso
    header("Location: iniciar_sesion.php?registro=exitoso");
    exit();
} else {
    // Si hubo un error, crea un mensaje codificado para pasarlo por URL
    $error_msg = urlencode("Error al registrar el usuario: " . $stmt->error);
    $stmt->close(); // Cierra la consulta
    $conn->close(); // Cierra la conexión
    // Redirige al formulario de registro con el mensaje de error
    header("Location: registrar.php?error=$error_msg");
    exit();
}
