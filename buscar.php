<?php
session_start();
require 'conexion.php';

$busqueda = $_GET['buscador'] ?? '';

// Consulta SQL con búsqueda por título (y opcionalmente por género también)
$sql = "SELECT PELICULAS.*, GENERO.NOMBRE AS NOMBRE_GENERO, 
        YEAR(PELICULAS.FECHA_ESTRENO) AS ANIO_ESTRENO
        FROM PELICULAS
        LEFT JOIN GENERO ON PELICULAS.ID_GENERO = GENERO.ID_GENERO
        WHERE PELICULAS.TITULO LIKE ? OR GENERO.NOMBRE LIKE ?
        ORDER BY PELICULAS.TITULO ASC";

$stmt = $conn->prepare($sql);
$likeBusqueda = "%" . $busqueda . "%";
$stmt->bind_param("ss", $likeBusqueda, $likeBusqueda);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="header.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./Imagenes/Logo_fondo_blanco.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
     <link rel="stylesheet" href="header.css" type="text/css">
</head>

<body>
    <header class="fixed-top cine-header">
        <div class="container py-2">
            <div class="row align-items-center ">
                <!--Contenedor que engloba el logo, buscador, botones-->
                <div class="col-12 d-flex flex-column flex-sm-row align-items-center justify-content-between order-sm-1 gap-2">
                    <!-- Logo -->
                    <div>
                        <a href="index.php">
                            <img src="./Imagenes/Logo_negro.png" alt="Logo" class="img-fluid" style="max-height: 60px;">
                        </a>
                    </div>

                    <!-- Botones de inicio de sesión -->
                    <div class="d-flex flex-md-row align-items-center order-sm-2 gap-2">
                        <?php if (isset($_SESSION['usuario_nombre'])): ?> <!--si no ha iniciado sesion no aparece nada-->
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
                            <input type="text" class="form-control search-box" name="buscador" placeholder="Buscar películas..." required>
                            <button class="btn search-btn" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark py-2"> <!--Categoria se combierte en icono desplazable-->
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
        <h2 class="text-center mb-4">Resultados para: <span class="text-warning"><?= htmlspecialchars($busqueda) ?></span></h2>

        <?php if ($resultado->num_rows > 0): ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <div class="col-6 col-md-4 mb-4">
                        <div class="card h-100 shadow">
                            <a href="detalles.php?id_peli=<?= $fila['ID_PELI'] ?>">
                                <img src="<?= $fila['IMAGEN'] ?>" class="card-img-top object-fit-cover" alt="<?= $fila['TITULO'] ?? 'Sin título' ?>">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?= $fila['TITULO'] ?? 'Sin título' ?></h5>
                                <div class="mb-2">
                                    <span class="badge bg-warning text-dark me-1"><?= $fila['NOMBRE_GENERO'] ?? 'Sin género' ?></span>
                                    <span class="badge bg-secondary"><?= $fila['ANIO_ESTRENO'] ?? 'Sin fecha' ?></span>
                                </div>
                                <span class="card-text">Duración: <?= isset($fila['DURACION']) ? $fila['DURACION'] . ' min' : 'Sin duración' ?></span><br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="rating">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <span><?= $fila['CALIFICACION'] ?? '0.0' ?>/5</span>
                                    </div>
                                    <a href="detalles.php?id_peli=<?= $fila['ID_PELI'] ?>" class="btn btn-sm btn-warning">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">No se encontraron resultados para "<strong><?= htmlspecialchars($busqueda) ?></strong>".</div>
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
</body>

</html>