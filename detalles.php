<?php
require 'conexion.php';
$id_peli = $_GET['id_peli'];
$sql = "SELECT * FROM peliculas where id_peli = $id_peli";
$resultado = $mysqli->query($sql);
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


</head>

<body>
    <header class="cine-header">
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
                        <a href="iniciar_sesion.php" class="btn btn-sm btn-warning">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                        </a>
                        <a href="registrar.php" class="btn btn-sm btn-warning">
                            <i class="bi bi-person-plus"></i> Registrarse
                        </a>
                    </div>
                    <!-- Barra de búsqueda -->
                    <div class="col-8 col-sm-5 order-sm-1">
                        <div class="input-group">
                            <input type="text" class="form-control search-box" placeholder="Buscar películas, actores...">
                            <button class="btn search-btn" type="button"> <!--Icono de buscar-->
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
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
                        <li class="nav-item">
                            <a class="nav-link categoria-cine" href="comentarios.php"><i class="bi bi-chat-left-text"></i> Comentarios</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

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
    <main class="container my-5">
        <h1 class="text-center mb-4">Dune: Parte Dos</h1>

        <div class="row">
            <div class="col-md-4">
                <img src="./Imagenes/Dune.jpg" class="img-fluid rounded shadow" alt="Dune: Parte Dos">
            </div>
            <div class="col-md-8">
                <h5>
                    Género:
                    <span class="badge bg-warning text-dark">Ciencia Ficción</span>
                </h5>
                <h5>Año: 2024</h5>
                <h5>Duración: 166 min</h5>
                <h5>Calificación: 4.8/5 <i class="bi bi-star-fill text-warning"></i></h5>
                <h5>Presupuesto: $190,000,000</h5>
                <h5>Recaudación total: $700,000,000</h5>
                <p class="mt-3"><strong>Biografía:</strong> La épica continuación del viaje de Paul Atreides mientras se une a los Fremen en su lucha contra los conspiradores que destruyeron a su familia.</p>
            </div>
        </div>

        <hr>

        <h3 class="mt-5">Actores que participan</h3>

        <div class="container my-4">
            <h4>Reparto</h4>
            <div class="position-relative">
                <div class="d-flex overflow-auto" style="scroll-snap-type: x mandatory;">
                    <div class="me-3 text-center" style="scroll-snap-align: start;">
                        <img src="./Imagenes/actor1.jpg" class="rounded" style="width: 100px; height: 140px; object-fit: cover;">
                        <div>David Bradley</div>
                    </div>
                    <div class="me-3 text-center" style="scroll-snap-align: start;">
                        <img src="./Imagenes/actor2.jpg" class="rounded" style="width: 100px; height: 140px; object-fit: cover;">
                        <div>Lars Mikkelsen</div>
                    </div>
                    <div class="me-3 text-center" style="scroll-snap-align: start;">
                        <img src="./Imagenes/actor3.jpg" class="rounded" style="width: 100px; height: 140px; object-fit: cover;">
                        <div>Christian Convery</div>
                    </div>
                    <div class="me-3 text-center" style="scroll-snap-align: start;">
                        <img src="./Imagenes/actor4.jpg" class="rounded" style="width: 100px; height: 140px; object-fit: cover;">
                        <div>Sofia Galasso</div>
                    </div>

                </div>
            </div>
        </div>
        <hr>
        <h3>Premios obtenidos</h3>
        <ul>
            <li>Oscar a Mejores Efectos Visuales (2024)</li>
            <li>BAFTA a Mejor Dirección (2024)</li>
        </ul>
        <hr class="my-4">
        <h4>Vota esta película</h4>
        <div class="star-rating mb-3">
            <i class="bi bi-star" data-value="1"></i>
            <i class="bi bi-star" data-value="2"></i>
            <i class="bi bi-star" data-value="3"></i>
            <i class="bi bi-star" data-value="4"></i>
            <i class="bi bi-star" data-value="5"></i>
        </div>

        <div class="mb-3">
            <label for="comentario" class="form-label">Tu comentario</label>
            <textarea class="form-control" id="comentario" rows="3" placeholder="Escribe tu opinión..."></textarea>
        </div>
        <button class="btn btn-primary">Enviar Voto</button>

        <div>
            <a href="index.html" class="btn btn-primary mt-4">
                <i class="bi bi-arrow-left"></i> Volver al listado
            </a>
        </div>
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
                        <li class="mb-2"><a href="contacto.php" class="footer-links text-decoration-none">Contacto</a></li>
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
        const stars = document.querySelectorAll('.star-rating i');
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = parseInt(star.getAttribute('data-value'));
                stars.forEach(s => {
                    if (parseInt(s.getAttribute('data-value')) <= value) {
                        s.classList.remove('bi-star');
                        s.classList.add('bi-star-fill', 'text-warning');
                    } else {
                        s.classList.remove('bi-star-fill', 'text-warning');
                        s.classList.add('bi-star');
                    }
                });
            });
        });
    </script>
</body>

</html>