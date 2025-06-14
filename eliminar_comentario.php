<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: iniciar_sesion.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$id_comentario = $_POST['id'] ?? null;

if (!$id_comentario) {
    die("ID del comentario no especificado.");
}

// Verificar propiedad del comentario
$sql = "SELECT ID_COMENT FROM comentarios WHERE ID_COMENT = ? AND ID_USER = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_comentario, $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Comentario no encontrado o no tienes permiso para eliminarlo.");
}

// Eliminar comentario
$sql_eliminar = "DELETE FROM comentarios WHERE ID_COMENT = ? AND ID_USER = ?";
$stmt_eliminar = $conn->prepare($sql_eliminar);
$stmt_eliminar->bind_param("ii", $id_comentario, $id_usuario);
if ($stmt_eliminar->execute()) {
    header("Location: comentario.php");
    exit;
} else {
    die("Error al eliminar el comentario.");
}
