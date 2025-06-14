<?php
session_start();
require_once 'conexion.php';

$id_usuario = $_SESSION['usuario_id'] ?? null; // Asegúrate que usas 'usuario_id' o el nombre correcto de la sesión
$nuevo_comentario = trim($_POST['comentario'] ?? '');
$id_comentario = intval($_POST['comentario_id'] ?? 0);

if (!$id_usuario) {
    // Usuario no autenticado
    header("Location: iniciar_sesion.php");
    exit;
}

if ($nuevo_comentario === '') {
    $error = "El comentario no puede estar vacío.";
} elseif ($id_comentario <= 0) {
    $error = "ID del comentario inválido.";
} else {
    // Verificar que el comentario pertenece al usuario antes de actualizar
    $sql_check = "SELECT 1 FROM comentarios WHERE ID_COMENT = ? AND ID_USER = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $id_comentario, $id_usuario);
    $stmt_check->execute();
    $resultado_check = $stmt_check->get_result();

    if ($resultado_check->num_rows === 0) {
        $error = "No tienes permiso para editar este comentario o no existe.";
    } else {
        $sql_update = "UPDATE comentarios SET COMENTARIO = ? WHERE ID_COMENT = ? AND ID_USER = ?";
        $stmt_update = $conn->prepare($sql_update);
        if ($stmt_update) {
            $stmt_update->bind_param("sii", $nuevo_comentario, $id_comentario, $id_usuario);
            if ($stmt_update->execute()) {
                header("Location: comentario.php?edit=ok");
                exit;
            } else {
                $error = "Error al actualizar el comentario.";
            }
            $stmt_update->close();
        } else {
            $error = "Error en la preparación de la consulta.";
        }
    }
    $stmt_check->close();
}

// Si hay error, puedes mostrarlo o redirigir con error (aquí ejemplo simple)
if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
    echo "<p><a href='editar_comentario.php?id=$id_comentario'>Volver a editar</a></p>";
}

$conn->close();
