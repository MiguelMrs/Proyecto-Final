<?php
session_start(); 
// Inicia la sesión de PHP para poder usar variables de sesión si fuera necesario.

require 'conexion.php'; 


if (!isset($_SESSION['id_user'])) {
    
    echo "<a href='iniciar_sesion.php'>Iniciar sesión</a>";
    exit;
    header("Location: login.php");
}

$id_user = $_SESSION['id_user'];

$id_peli = intval($_POST['id_peli'] ?? 0); // Si no existe, usa 0 como valor por defecto. Se convierte a entero para evitar inyección.

$calificacion = intval($_POST['voto'] ?? 0); 
// Recoge el valor enviado por POST del campo 'voto' (la calificación o estrellas que dio el usuario).
// Si no existe, asigna 0. También se convierte a entero.

$comentario = trim($_POST['comentario'] ?? ''); 
// Recoge el comentario enviado por POST.
// Si no existe, queda como cadena vacía.
// La función trim() elimina espacios en blanco al inicio y al final del texto.

if ($id_peli <= 0 || $calificacion < 1 || $calificacion > 5) {
    die('Datos inválidos.');
}
// Validación básica:
// Si el id de la película es 0 o negativo, o la calificación es menor que 1 o mayor que 5,
// termina la ejecución y muestra el mensaje 'Datos inválidos.'

// Fecha actual
$fecha_comentario = date('Y-m-d'); 
// Obtiene la fecha actual en formato 'Año-Mes-Día' para guardar la fecha del comentario.


// Preparar la consulta SQL para insertar el voto y comentario en la tabla 'comentarios'
$sql = "INSERT INTO comentarios (ID_PELI, CALIFICACION, COMENTARIO, FECHA_COMENTARIO)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql); 
// Prepara la consulta para evitar inyección SQL, usando placeholders '?'

$stmt->bind_param("iiss", $id_peli, $calificacion, $comentario, $fecha_comentario); 
// Asocia los valores a los placeholders:
// "iiss" indica que los dos primeros parámetros son enteros (integer) y los dos últimos son cadenas (string).
// $id_peli, $calificacion, $comentario y $fecha_comentario se enlazan en ese orden.

if ($stmt->execute()) { 
    // Si la ejecución del insert fue correcta...

    // Preparar consulta para obtener la media de calificaciones para esa película
    $sql_avg = "SELECT AVG(CALIFICACION) as promedio FROM comentarios WHERE ID_PELI = ?";
    $stmt_avg = $conn->prepare($sql_avg);  // Prepara la consulta para evitar inyección SQL
    $stmt_avg->bind_param("i", $id_peli);   // Asocia el id de la película al placeholder
    $stmt_avg->execute(); // Ejecuta la consulta
    

    $resultado = $stmt_avg->get_result();     // Obtiene el resultado de la consulta
    $row = $resultado->fetch_assoc();   // Obtiene la fila como un array asociativo
    
    $promedio = round($row['promedio'], 1);  // Redondea la media a 1 decimal
    $sql_update = "UPDATE peliculas SET CALIFICACION = ? WHERE ID_PELI = ?";  // Preparar consulta para actualizar la calificación promedio en la tabla 'peliculas'
    $stmt_update = $conn->prepare($sql_update);    // Prepara la consulta para actualización
 

    $stmt_update->bind_param("di", $promedio, $id_peli);  // Asocia los parámetros: 'd' para decimal (float) y 'i' para entero

   
    $stmt_update->execute(); // Ejecuta la actualización
    header("Location: detalles.php?id_peli=" . $id_peli); 

} else {
    // Si hubo un error al insertar el comentario, muestra el mensaje de error.
    echo "Error al guardar el comentario: " . $stmt->error;
}
