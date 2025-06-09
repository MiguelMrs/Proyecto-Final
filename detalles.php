<?php
session_start();
require 'conexion.php';

$id_peli = isset($_GET['id_peli']) ? intval($_GET['id_peli']) : 0;
if ($id_peli <= 0) {
    die("Película no encontrada");
    exit;
}

// Obtener detalles de la película
$stmt = $conn->prepare("
    SELECT 
        p.titulo, p.FECHA_ESTRENO, p.duracion, p.calificacion, 
        p.presupuesto, p.total_taquilla, p.IMAGEN, p.biografia,
        g.NOMBRE AS nombre_genero, 
        d.nombre AS director
    FROM peliculas p
    JOIN genero g ON p.id_genero = g.id_genero
    JOIN directores d ON p.id_director = d.id_director
    WHERE p.id_peli = ?
");
$stmt->bind_param("i", $id_peli);
$stmt->execute();
$resultado = $stmt->get_result();
$peli = $resultado->fetch_assoc();

// Obtener actores
$stmt_actores = $conn->prepare("
    SELECT a.nombre, a.foto
    FROM peliculas_actores r
    JOIN actores a ON r.id_actor = a.id_actor
    WHERE r.id_peli = ?
");
$stmt_actores->bind_param("i", $id_peli);
$stmt_actores->execute();
$actores = $stmt_actores->get_result();

// Obtener premios
$stmt_premios = $conn->prepare("
    SELECT id_peli, nombre_premio, ano
    FROM premio
    WHERE id_peli = ?
");
$stmt_premios->bind_param("i", $id_peli);
$stmt_premios->execute();
$premios = $stmt_premios->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineRate</title>
    <link rel="icon" href="./Imagenes/Logo_fondo_blanco.png" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="header.css" type="text/css">
    <style>
        .star-rating i {
            font-size: 2rem;
            color: gray;
            cursor: pointer;
        }

        .star-rating i.selected {
            color: gold;
        }
    </style>
</head>

<body>
    <header class="fixed-top cine-header">
        <div class="container py-2">
            <div class="row align-items-center">
                <div class="col-12 d-flex flex-column flex-sm-row align-items-center justify-content-between order-sm-1 gap-2">
                    <!-- Logo -->
                    <div>
                        <a href="index.php">
                            <img src="./Imagenes/Logo_negro.png" alt="Logo" class="img-fluid" style="max-height: 60px;">
                        </a>
                    </div>

                    <!-- Botones de inicio de sesión -->
                    <div class="d-flex flex-md-row align-items-center order-sm-2 gap-2">
                        <?php if (isset($_SESSION['usuario_nombre'])): ?>
                            <span class="text-white fw-semibold">
                                <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>
                            </span>
                            <a href="cerrar_sesion.php" class="btn btn-sm btn-outline-danger ms-2">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                            </a>
                        <?php else: ?>
                            <a href="iniciar_sesion.php" class="btn btn-sm btn-warning">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                            </a>
                            <a href="registrar.php" class="btn btn-sm btn-warning">
                                <i class="bi bi-person-plus"></i> Registrarse
                            </a>
                        <?php endif; ?>
                    </div>
                    <!-- Barra de búsqueda -->
                    <div class="col-8 col-sm-5 order-sm-1">
                        <form action="buscar.php" method="get" class="input-group">
                            <input type="text" class="form-control search-box" name="buscador" placeholder="Buscar películas" required>
                            <button class="btn search-btn" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark py-2">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#categoria-cine" aria-controls="navbarCine" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="categoria-cine">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link categoria-cine" href="index.php"><i class="bi bi-house-door"></i> Inicio</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link categoria-cine dropdown-toggle" href="#" id="icono-menu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-tags"></i> Géneros
                            </a>
                            <ul class="dropdown-menu dropdown-menu-genero" aria-labelledby="icono-menu">
                                <li><a class="dropdown-item categoria-cine" href="accion.php">Acción</a></li>
                                <li><a class="dropdown-item categoria-cine" href="drama.php">Drama</a></li>
                                <li><a class="dropdown-item categoria-cine" href="comedia.php">Comedia</a></li>
                                <li><a class="dropdown-item categoria-cine" href="cienciaficcion.php">Ciencia Ficción</a></li>
                                <li><a class="dropdown-item categoria-cine" href="terror.php">Terror</a></li>
                                <li><a class="dropdown-item categoria-cine" href="romance.php">Romance</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link categoria-cine" href="actores.php"><i class="bi bi-people"></i> Actores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link categoria-cine" href="directores.php"><i class="bi bi-camera-reels"></i> Directores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link categoria-cine" href="premios.php"><i class="bi bi-trophy"></i> Premios</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        <h1 class="text-center mb-4"><?php echo htmlspecialchars($peli['titulo']); ?></h1>

        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $peli['IMAGEN']; ?>" class="img-fluid rounded shadow" alt="<?php echo htmlspecialchars($peli['titulo']); ?>">
            </div>

            <div class="col-md-8 mt-3">
                <h5><span class="fw-bold">Género:</span> <span class="badge bg-warning text-dark"><?php echo htmlspecialchars($peli['nombre_genero']); ?></span></h5>
                <h5><span class="fw-bold">Año: </span><?php echo htmlspecialchars($peli['FECHA_ESTRENO']); ?></h5>
                <h5><span class="fw-bold">Duración: </span><?php echo htmlspecialchars($peli['duracion']); ?> min</h5>
                <h5><span class="fw-bold">Calificación: </span><?php echo htmlspecialchars($peli['calificacion']); ?>/5 <i class="bi bi-star-fill text-warning"></i></h5>
                <h5><span class="fw-bold">Presupuesto:</span> <?php echo number_format($peli['presupuesto'], 0, ',', '.'); ?> €</h5>
                <h5><span class="fw-bold">Recaudación total:</span> <?php echo number_format($peli['total_taquilla'], 0, ',', '.'); ?> €</h5>
                <h5><span class="fw-bold">Biografía:</span> <?php echo htmlspecialchars($peli['biografia']); ?></h5>
                <h5><span class="fw-bold">Director:</span> <?php echo htmlspecialchars($peli['director']); ?></h5>
            </div>
        </div>

        <hr>

        <h3 class="mt-5">Actores que participan</h3>
        <div class="container my-4">
            <h4>Reparto</h4>
            <div class="position-relative ">
                <!-- Comprobar si hay actores en el resultado de la consulta -->
                <?php if ($actores->num_rows > 0): ?>
                    <!-- Contenedor flexible con scroll horizontal para mostrar los actores -->
                    <div class="d-flex overflow-auto pb-3" style="scroll-snap-type: x mandatory;">
                        <!-- Bucle para recorrer cada fila de actor en el resultado -->
                        <?php while ($actor = $actores->fetch_assoc()): ?>
                            <!-- Caja para cada actor, con centrado y espacio horizontal -->
                            <div class="text-center mx-2" style="min-width: 100px; scroll-snap-align: start;">
                                <!-- Imagen del actor, cargada desde la carpeta Imagenes, con estilos para tamaño y forma -->
                                <img src="./Imagenes/<?php echo htmlspecialchars($actor['foto']); ?>"
                                    class="rounded mb-2 mx-3"
                                    alt="<?php echo htmlspecialchars($actor['nombre']); ?>"
                                    style="width: 100px; height: 140px; object-fit: cover;">
                                <!-- Nombre del actor, mostrado debajo de la imagen -->
                                <div class="small"><?php echo htmlspecialchars($actor['nombre']); ?></div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <!-- Si no hay actores, mostrar mensaje informativo -->
                <?php else: ?>
                    <p class="text-muted">No hay datos disponibles en estos momentos.</p>
                <?php endif; ?>
            </div>
        </div>

        <hr>

        <h3>Premios obtenidos</h3>
        <ul>
            <?php if ($premios->num_rows > 0): ?>
                <?php while ($premio = $premios->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($premio['nombre_premio']); ?> (<?php echo $premio['ano']; ?>)</li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>Ningún premio ganado</li>
            <?php endif; ?>
        </ul>

        <hr>

        <?php
        // Consulta para obtener comentarios de la película con nombre de usuario
        $sql = "SELECT c.CALIFICACION, c.COMENTARIO, c.FECHA_COMENTARIO, u.nombre AS usuario
                FROM comentarios c
                LEFT JOIN usuarios u ON c.ID_USER = u.ID_USER
                WHERE c.ID_PELI = ? 
                ORDER BY c.FECHA_COMENTARIO DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_peli);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo "<p>No hay comentarios todavía para esta película.</p>";
        } else {
            echo "<h4>Comentarios de usuarios:</h4>";
            echo "<ul class='list-group'>";
            while ($row = $result->fetch_assoc()) {
                // La función str_repeat() en PHP repite una cadena de texto un número determinado de veces.
                $estrellas = str_repeat('★', $row['CALIFICACION']) . str_repeat('☆', 5 - $row['CALIFICACION']);

                // Nombre del usuario o anónimo
                $usuario = $row['usuario'] ?? 'Anónimo';

                echo "<li class='list-group-item'>";
                echo "<strong>$usuario</strong> <small>(" . $row['FECHA_COMENTARIO'] . ")</small><br>";
                echo "<span style='color:gold; font-size:1.2em;'>$estrellas</span><br>";
                echo nl2br(htmlspecialchars($row['COMENTARIO']));
                echo "</li>";
            }
            echo "</ul>";
        }
        ?>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <?php
            // Verificar si el usuario ya votó esta película
            $stmt_voto = $conn->prepare("SELECT ID_COMENT FROM comentarios WHERE ID_PELI = ? AND ID_USER = ?");
            $stmt_voto->bind_param("ii", $id_peli, $_SESSION['usuario_id']);
            $stmt_voto->execute();
            $result_voto = $stmt_voto->get_result();

            if ($result_voto->num_rows == 0):
            ?>
                <hr>
                <h3>Vota y comenta</h3>
                <form action="guardar_voto.php" method="post" id="form-voto">
                    <input type="hidden" name="id_peli" value="<?php echo htmlspecialchars($id_peli); ?>">
                    <input type="hidden" name="voto" id="voto" value="0">

                    <div class="star-rating mb-3">
                        <i class="bi bi-star" data-value="1"></i>
                        <i class="bi bi-star" data-value="2"></i>
                        <i class="bi bi-star" data-value="3"></i>
                        <i class="bi bi-star" data-value="4"></i>
                        <i class="bi bi-star" data-value="5"></i>
                    </div>

                    <div class="mb-3">
                        <label for="comentario" class="form-label">Tu comentario</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="3" placeholder="Escribe tu opinión..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-votar btn-primary">Enviar Voto</button>
                </form>
            <?php else: ?>
                <div class="alert alert-info mt-4">
                    Ya has votado y comentado esta película. ¡Gracias por tu participación!
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-warning mt-4">
                <a href="iniciar_sesion.php" class="alert-link">Inicia sesión</a> para poder votar y comentar esta película.
            </div>
        <?php endif; ?>

    </main>

    <footer class="bg-dark text-white pt-4 pb-2">
        <div class="container">
            <div class="row">
                <!-- Géneros -->
                <div class="col-md-2 col-6 mb-4">
                    <h5 class="text-warning mb-3">Géneros</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="accion.php" class="footer-links text-decoration-none">Acción</a></li>
                        <li class="mb-2"><a href="drama.php" class="footer-links text-decoration-none">Drama</a></li>
                        <li class="mb-2"><a href="comedia.php" class="footer-links text-decoration-none">Comedia</a></li>
                        <li class="mb-2"><a href="cienciaficcion.php" class="footer-links text-decoration-none">Ciencia Ficción</a></li>
                    </ul>
                </div>

                <!-- Información legal -->
                <div class="col-md-4 col-6 mb-4">
                    <h5 class="text-warning mb-3">Legal</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="terminos.php" class="footer-links text-decoration-none">Términos de uso</a></li>
                        <li class="mb-2"><a href="privacidad.php" class="footer-links text-decoration-none">Política de privacidad</a></li>
                        <li class="mb-2"><a href="cookies.php" class="footer-links text-decoration-none">Política de cookies</a></li>
                        <li class="mb-2"><a href="" class="footer-links text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
            </div>
            <!-- Sección Logo y Redes Sociales -->
            <div class="col-md-4 mb-4">
                <img src="./Imagenes/Logo_negro.png" alt="CineRate" class="mb-3" style="max-height: 50px;">
                <div class="social-icons">
                    <a href="#" class="text-white me-3"><i class="bi bi-facebook social-icons"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-twitter social-icons"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-instagram social-icons"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-youtube social-icons"></i></a>
                </div>
            </div>
            <hr class="my-4 bg-secondary">

            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small">© 2025 CineRate. Todos los derechos reservados de Miguel Ángel Rodríguez Sojo.</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const stars = document.querySelectorAll('.star-rating i'); // 1. Busca todos los iconos de estrellas dentro del contenedor con clase "star-rating"
        const inputVoto = document.getElementById('voto'); // 2. Busca el campo oculto donde guardaremos el número de estrellas seleccionadas

        // 3. Por cada estrella encontrada, le agregamos un evento para cuando hagas clic en ella
        stars.forEach(star => {
            star.addEventListener('click', () => {
                // 4. Al hacer clic, sacamos el número que tiene esa estrella (ejemplo: 1, 2, 3, 4 o 5)
                const value = parseInt(star.getAttribute('data-value'));

                // 5. Guardamos ese número en el campo oculto para enviar después en el formulario
                inputVoto.value = value;

                // 6. Ahora, actualizamos la apariencia de todas las estrellas:
                stars.forEach(s => {
                    if (parseInt(s.getAttribute('data-value')) <= value) {
                        // 7. Si la estrella está dentro del rango seleccionado, la pintamos como estrella llena y amarilla
                        s.classList.remove('bi-star'); // Quitamos estrella vacía
                        s.classList.add('bi-star-fill', 'text-warning'); // Ponemos estrella llena y amarilla
                    } else {
                        // 8. Si la estrella está fuera del rango seleccionado, la dejamos vacía y sin color
                        s.classList.remove('bi-star-fill', 'text-warning'); // Quitamos estrella llena y color
                        s.classList.add('bi-star'); // Ponemos estrella vacía
                    }
                });
            });
        });
    </script>
</body>

</html>