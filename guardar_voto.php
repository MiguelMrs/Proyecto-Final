<?php
session_start(); // Inicia la sesión para acceder a variables de sesión
require 'conexion.php'; // Incluye el archivo de conexión a la base de datos

// Verificar si el usuario ha iniciado sesión, si no, se detiene la ejecución
if (!isset($_SESSION['usuario_id'])) {
    die("Debes iniciar sesión para comentar."); // Mensaje y fin del script si no hay sesión
}

// Obtener datos enviados desde el formulario y asegurarse que son enteros o cadenas limpias
$id_user = intval($_SESSION['usuario_id']); // ID del usuario desde la sesión (convertido a entero)
$id_peli = intval($_POST['id_peli'] ?? 0); // ID de la película, si no viene, 0
$calificacion = intval($_POST['voto'] ?? 0); // Calificación (voto) del 1 al 5, si no viene 0
$comentario = trim($_POST['comentario'] ?? ''); // Comentario, limpiando espacios en blanco

// Validaciones básicas para evitar datos inválidos
if ($id_peli <= 0 || $calificacion < 1 || $calificacion > 5 || empty($comentario)) {
    $_SESSION['error'] = 'Datos inválidos'; // Guarda mensaje de error en sesión
    header("Location: detalles.php?id_peli=$id_peli"); // Redirige a la página de detalles de la película
    exit; // Detiene la ejecución del script
}

// Preparar la inserción del comentario en la base de datos
$fecha = date('Y-m-d'); // Fecha actual en formato año-mes-día
$sql = "INSERT INTO comentarios (ID_PELI, ID_USER, CALIFICACION, COMENTARIO, FECHA_COMENTARIO) 
        VALUES (?, ?, ?, ?, ?)"; // Consulta SQL con placeholders

$stmt = $conn->prepare($sql); // Preparar la consulta para evitar inyección SQL
$stmt->bind_param("iiiss", $id_peli, $id_user, $calificacion, $comentario, $fecha); 
// Vincula variables a la consulta: dos enteros (i), dos enteros (i), una cadena (s), una cadena (s)

// Ejecutar la consulta para insertar el comentario
if ($stmt->execute()) {
    // Si se insertó correctamente, calcular el promedio actualizado de calificaciones de la película
    $sql_avg = "SELECT AVG(CALIFICACION) as promedio FROM comentarios WHERE ID_PELI = ?";
    $stmt_avg = $conn->prepare($sql_avg); // Prepara consulta para promedio
    $stmt_avg->bind_param("i", $id_peli); // Vincula el id_peli
    $stmt_avg->execute(); // Ejecuta la consulta
    $promedio = round($stmt_avg->get_result()->fetch_assoc()['promedio'], 1); 
    // Obtiene el promedio y redondea a 1 decimal

    // Actualiza el campo CALIFICACION en la tabla peliculas con el nuevo promedio
    $conn->query("UPDATE peliculas SET CALIFICACION = $promedio WHERE ID_PELI = $id_peli");

    $_SESSION['mensaje'] = 'Comentario guardado correctamente'; // Mensaje de éxito
} else {
    $_SESSION['error'] = 'Error al guardar el comentario'; // Mensaje de error si no se pudo insertar
}

// Redirige nuevamente a la página de detalles de la película para mostrar resultados o mensajes
header("Location: detalles.php?id_peli=$id_peli");
exit; // Finaliza el script
