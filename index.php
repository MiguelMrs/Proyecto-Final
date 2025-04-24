<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineRate</title>
    <link rel="stylesheet" href="index.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Bootstrap Icons -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>

<body>
    <header class="cine-header">
        <div class="container py-2">
            <div class="row align-items-center">
                <!-- Barra de búsqueda -->
                <div class="col-md-3">
                    <a href="index.php"> <img src="./Imagenes/Logo.png" alt="Logo" class="img-fluid" style="max-height: 60px;"></a>

                </div>
                <!-- Barra de búsqueda -->
                <div class="col-md-5">
                    <div class="input-group">
                        <input type="text" class="form-control search-box" placeholder="Buscar películas, actores...">
                        <button class="btn search-btn" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <!-- Iconos de usuario  -->
                <div class="col-md-4 text-end">
                    <a href="#" class="btn btn-sm btn-warning me-2"><i class="bi bi-box-arrow-in-right"></i> Iniciar sesión</a>
                    <a href="#" class="btn btn-sm btn-warning"><i class="bi bi-person-plus"></i> Registrarse</a>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-1">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCine" aria-controls="navbarCine" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCine">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link nav-link-cine active" href="#"><i class="bi bi-house-door"></i> Inicio</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-cine dropdown-toggle" href="#" id="navbarDropdownGeneros" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-tags"></i> Géneros
                            </a>
                            <ul class="dropdown-menu dropdown-menu-cine" aria-labelledby="navbarDropdownGeneros">
                                <li><a class="dropdown-item dropdown-item-cine" href="#">Acción</a></li>
                                <li><a class="dropdown-item dropdown-item-cine" href="#">Drama</a></li>
                                <li><a class="dropdown-item dropdown-item-cine" href="#">Comedia</a></li>
                                <li><a class="dropdown-item dropdown-item-cine" href="#">Ciencia Ficción</a></li>
                                <li><a class="dropdown-item dropdown-item-cine" href="#">Terror</a></li>
                                <li><a class="dropdown-item dropdown-item-cine" href="#">Romance</a></li>
                                <!-- Estos se cargarían dinámicamente desde tu tabla GENERO -->
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-cine" href="#"><i class="bi bi-people"></i> Actores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-cine" href="#"><i class="bi bi-camera-reels"></i> Directores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-cine" href="#"><i class="bi bi-trophy"></i> Premios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-cine" href="#"><i class="bi bi-chat-left-text"></i> Comentarios</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>