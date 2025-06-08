<<?php
session_start();
require 'conexion.php';

// Verificar que el ID de usuario existe en la base de datos
$id_user = $_SESSION['id_user'];
$sql_check_user = "SELECT ID_USER FROM usuarios WHERE ID_USER = ?";
$stmt_check_user = $conn->prepare($sql_check_user);
$stmt_check_user->bind_param("i", $id_user);
$stmt_check_user->execute();
$result_check_user = $stmt_check_user->get_result();

if ($result_check_user->num_rows === 0) {
    session_destroy(); // Destruir sesión si el usuario no existe
    $_SESSION['error'] = 'Tu cuenta ya no existe. Por favor, inicia sesión nuevamente.';
    header("Location: iniciar_sesion.php");
    exit;
}

$id_peli = intval($_POST['id_peli'] ?? 0);
$calificacion = intval($_POST['voto'] ?? 0);
$comentario = trim($_POST['comentario'] ?? '');

// Validaciones
if ($id_peli <= 0) {
    $_SESSION['error'] = 'Película no válida';
    header("Location: index.php");
    exit;
}

if ($calificacion < 1 || $calificacion > 5) {
    $_SESSION['error'] = 'La calificación debe estar entre 1 y 5 estrellas';
    header("Location: detalles.php?id_peli=" . $id_peli);
    exit;
}

if (empty($comentario)) {
    $_SESSION['error'] = 'El comentario no puede estar vacío';
    header("Location: detalles.php?id_peli=" . $id_peli);
    exit;
}

// Verificar si el usuario ya comentó esta película
$sql_check = "SELECT ID_COMENT FROM comentarios WHERE ID_PELI = ? AND ID_USER = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id_peli, $id_user);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    $_SESSION['error'] = 'Ya has comentado esta película';
    header("Location: detalles.php?id_peli=" . $id_peli);
    exit;
}

// Insertar el nuevo comentario
$fecha_comentario = date('Y-m-d');
$sql = "INSERT INTO comentarios (ID_PELI, ID_USER, CALIFICACION, COMENTARIO, FECHA_COMENTARIO)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiss", $id_peli, $id_user, $calificacion, $comentario, $fecha_comentario);

if ($stmt->execute()) {
    // Actualizar calificación promedio de la película
    $sql_avg = "SELECT AVG(CALIFICACION) as promedio FROM comentarios WHERE ID_PELI = ?";
    $stmt_avg = $conn->prepare($sql_avg);
    $stmt_avg->bind_param("i", $id_peli);
    $stmt_avg->execute();
    
    $resultado = $stmt_avg->get_result();
    $row = $resultado->fetch_assoc();
    
    $promedio = round($row['promedio'], 1);
    
    $sql_update = "UPDATE peliculas SET CALIFICACION = ? WHERE ID_PELI = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("di", $promedio, $id_peli);
    $stmt_update->execute();
    
    $_SESSION['mensaje'] = '¡Gracias por tu comentario!';
} else {
    $_SESSION['error'] = "Error al guardar el comentario. Por favor, inténtalo nuevamente.";
    // Opcional: registrar el error real para diagnóstico
    error_log("Error al guardar comentario: " . $stmt->error);
}

header("Location: detalles.php?id_peli=" . $id_peli);
exit;
?>