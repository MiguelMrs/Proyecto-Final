<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: iniciar_sesion.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// Ejecutar la consulta para obtener comentarios del usuario
$sql = "SELECT c.ID_COMENT, c.COMENTARIO, c.FECHA_COMENTARIO, p.TITULO AS pelicula
        FROM comentarios c
        INNER JOIN peliculas p ON c.ID_PELI = p.ID_PELI
        WHERE c.ID_USER = ?
        ORDER BY c.FECHA_COMENTARIO DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result_user_comentarios = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mis Comentarios - CineRate</title>
    <link rel="icon" href="./Imagenes/Logo_fondo_blanco.png" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="header.css" type="text/css" />
</head>

<body>
    <header class="fixed-top cine-header">
        <div class="container py-2">
            <div class="row align-items-center ">
                <div class="col-12 d-flex flex-column flex-sm-row align-items-center justify-content-between order-sm-1 gap-2">
                    <div>
                        <a href="index.php">
                            <img src="./Imagenes/Logo_negro.png" alt="Logo" class="img-fluid" style="max-height: 60px;" />
                        </a>
                    </div>

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

                    <div class="col-8 col-sm-5 order-sm-1">
                        <form action="buscar.php" method="get" class="input-group">
                            <input type="text" class="form-control search-box" name="buscador" placeholder="Buscar películas" required />
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
                        <li class="nav-item"><a class="nav-link categoria-cine" href="index.php"><i class="bi bi-house-door"></i> Inicio</a></li>
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
                        <li class="nav-item"><a class="nav-link categoria-cine" href="actores.php"><i class="bi bi-people"></i> Actores</a></li>
                        <li class="nav-item"><a class="nav-link categoria-cine" href="directores.php"><i class="bi bi-camera-reels"></i> Directores</a></li>
                        <li class="nav-item"><a class="nav-link categoria-cine" href="premios.php"><i class="bi bi-trophy"></i> Premios</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5 pt-5">
        <h1 class="text-center mb-4">Mis Comentarios</h1>

        <?php if ($result_user_comentarios && $result_user_comentarios->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($comentario = $result_user_comentarios->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Película: <?= htmlspecialchars($comentario['pelicula']) ?></strong><br>
                            <small>Fecha: <?= htmlspecialchars($comentario['FECHA_COMENTARIO']) ?></small><br>
                            <?= nl2br(htmlspecialchars($comentario['COMENTARIO'])) ?>
                        </div>
                        <div class="btn-group btn-group-sm " role="group" aria-label="Acciones comentario">
                            <a href="editar_comentario.php?id=<?= htmlspecialchars($comentario['ID_COMENT']) ?>" class="btn btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="eliminar_comentario.php" method="post" onsubmit="return confirm('¿Seguro que quieres eliminar este comentario?');" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($comentario['ID_COMENT']) ?>">
                                <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="text-center">Aún no has hecho ningún comentario.</p>
        <?php endif; ?>
    </main>

    <footer class="bg-dark text-white pt-4 pb-2 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-6 mb-4">
                    <h5 class="text-warning mb-3">Géneros</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="accion.php" class="footer-links text-decoration-none">Acción</a></li>
                        <li class="mb-2"><a href="drama.php" class="footer-links text-decoration-none">Drama</a></li>
                        <li class="mb-2"><a href="comedia.php" class="footer-links text-decoration-none">Comedia</a></li>
                        <li class="mb-2"><a href="cienciaficcion.php" class="footer-links text-decoration-none">Ciencia Ficción</a></li>
                    </ul>
                </div>

                <div class="col-md-4 col-6 mb-4">
                    <h5 class="text-warning mb-3">Legal</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="terminos.php" class="footer-links text-decoration-none">Términos de uso</a></li>
                        <li class="mb-2"><a href="privacidad.php" class="footer-links text-decoration-none">Política de privacidad</a></li>
                        <li class="mb-2"><a href="cookies.php" class="footer-links text-decoration-none">Política de cookies</a></li>
                        <li class="mb-2"><a href="#" class="footer-links text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <img src="./Imagenes/Logo_negro.png" alt="CineRate" class="mb-3" style="max-height: 50px;" />
                <p class="mb-0">© 2023 CineRate, todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
