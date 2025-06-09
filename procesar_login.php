<?php
session_start();  // Inicia la sesión para poder usar variables de sesión

include 'conexion.php'; // Incluye el archivo que contiene la conexión a la base de datos

// Obtiene los datos enviados desde el formulario por método POST
$email = $_POST['email'];
$password = $_POST['password'];

// Prepara la consulta SQL para buscar un usuario con el email proporcionado
$sql = "SELECT * FROM usuarios WHERE EMAIL = ?";
$stmt = $conn->prepare($sql); // Prepara la consulta evitando inyección SQL
$stmt->bind_param("s", $email); // Vincula el parámetro $email en la consulta (tipo string)
$stmt->execute(); // Ejecuta la consulta
$resultado = $stmt->get_result(); // Obtiene el resultado de la consulta

// Verifica si encontró un usuario con ese correo
if ($fila = $resultado->fetch_assoc()) {
    // Si existe el usuario, verifica que la contraseña ingresada coincida con el hash almacenado
    if (password_verify($password, $fila['PASSWORD'])) {
        // Si la contraseña es correcta, guarda información del usuario en variables de sesión
        $_SESSION['usuario_id'] = $fila['ID_USER'];
        $_SESSION['usuario_nombre'] = $fila['NOMBRE']; // Este dato se usa luego, por ejemplo en el header

        // Redirige al usuario a la página principal
        header("Location: index.php");
        exit(); // Para que no se ejecute código después de la redirección
    } else {
        // Si la contraseña no coincide, muestra mensaje de error
        echo "Contraseña incorrecta";
    }
} else {
    // Si no se encontró un usuario con ese correo, muestra mensaje de error
    echo "Correo no encontrado";
}
?>
