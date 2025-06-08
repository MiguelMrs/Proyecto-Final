<?php
session_start();
require 'conexion.php';

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    die("Debes iniciar sesión para comentar.");
}

// Obtener datos del formulario
$id_user = intval($_SESSION['usuario_id']);
$id_peli = intval($_POST['id_peli'] ?? 0);
$calificacion = intval($_POST['voto'] ?? 0);
$comentario = trim($_POST['comentario'] ?? '');

// Validaciones básicas
if ($id_peli <= 0 || $calificacion < 1 || $calificacion > 5 || empty($comentario)) {
    $_SESSION['error'] = 'Datos inválidos';
    header("Location: detalles.php?id_peli=$id_peli");
    exit;
}

// Insertar comentario
$fecha = date('Y-m-d');
$sql = "INSERT INTO comentarios (ID_PELI, ID_USER, CALIFICACION, COMENTARIO, FECHA_COMENTARIO) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiss", $id_peli, $id_user, $calificacion, $comentario, $fecha);

if ($stmt->execute()) {
    // Actualizar promedio de calificación
    $sql_avg = "SELECT AVG(CALIFICACION) as promedio FROM comentarios WHERE ID_PELI = ?";
    $stmt_avg = $conn->prepare($sql_avg);
    $stmt_avg->bind_param("i", $id_peli);
    $stmt_avg->execute();
    $promedio = round($stmt_avg->get_result()->fetch_assoc()['promedio'], 1);

    $conn->query("UPDATE peliculas SET CALIFICACION = $promedio WHERE ID_PELI = $id_peli");

    $_SESSION['mensaje'] = 'Comentario guardado correctamente';
} else {
    $_SESSION['error'] = 'Error al guardar el comentario';
}

header("Location: detalles.php?id_peli=$id_peli");
exit;
