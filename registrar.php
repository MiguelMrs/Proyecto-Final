<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - CineRate</title>
    <link rel="icon" href="./Imagenes/Logo_fondo_blanco.png" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="iniciosesion.css" type="text/css">
</head>

<body>
<header class="cine-header">
    <div class="container py-2">
        <div class="row align-items-center">
            <div class="col-12 d-flex flex-column flex-sm-row align-items-center justify-content-between order-sm-1 gap-2">
                <div>
                    <a href="index.php">
                        <img src="./Imagenes/Logo_negro.png" alt="Logo" class="img-fluid" style="max-height: 60px;">
                    </a>
                </div>
                <div class="d-flex flex-md-row align-items-center order-sm-2 gap-2">
                    <a href="iniciar_sesion.php" class="btn btn-sm btn-warning">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                    </a>
                    <a href="registrar.php" class="btn btn-sm btn-warning">
                        <i class="bi bi-person-plus"></i> Registrarse
                    </a>
                </div>
                <div class="col-8 col-sm-5 order-sm-1">
                    <div class="input-group">
                        <input type="text" class="form-control search-box" placeholder="Buscar películas, actores...">
                        <button class="btn search-btn" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark py-2">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#categoria-cine">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="categoria-cine">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link categoria-cine" href="index.php"><i class="bi bi-house-door"></i> Inicio</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link categoria-cine dropdown-toggle" href="#" id="icono-menu" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-tags"></i> Géneros
                        </a>
                        <ul class="dropdown-menu dropdown-menu-genero">
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
                    <li class="nav-item"><a class="nav-link categoria-cine" href="comentarios.php"><i class="bi bi-chat-left-text"></i> Comentarios</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="flex-grow-1 d-flex align-items-center">
    <div class="container my-5">
        <div class="login-container">
            <div class="cine-brand">
                <img src="./Imagenes/Logo_fondo_blanco.png" alt="CineRate">
                <h2>Registrarse</h2>
                <p class="text-muted">Crea tu cuenta para guardar tus películas favoritas</p>
            </div>
            
            <form action="procesar_registro.php" method="POST">
                <div class="mb-4">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Tu nombre">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="tucorreo@ejemplo.com">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="••••••••">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-cine w-100 mb-3">Registrarse</button>
                
                <div class="text-center">
                    <p class="mb-0">¿Ya tienes una cuenta? <a href="iniciar_sesion.php" class="text-warning text-decoration-none">Inicia sesión</a></p>
                </div>
            </form>
        </div>
    </div>
</main>

<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p class="mb-0">© 2023 CineRate. Todos los derechos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
