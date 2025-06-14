<?php
session_start();
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
                    <h1>Política de Cookies</h1>
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
                            <a class="nav-link categoria-cine" href="comentario.php"><i class="bi bi-chat-left-text"></i> Comentarios</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
  <main class="container my-5">
        <h1>Condiciones de Uso</h1>
        <p>Bienvenido a nuestra Biblioteca de Cine en línea. Al acceder y utilizar este sitio web, aceptas cumplir con las siguientes condiciones de uso. Si no estás de acuerdo con estos términos, te recomendamos que no utilices este sitio.</p>

        <h2>1. Aceptación de los términos</h2>
        <p>Al utilizar este sitio web, el usuario acepta estar sujeto a las condiciones establecidas en este documento. El sitio web se reserva el derecho de modificar estos términos en cualquier momento y sin previo aviso. Es responsabilidad del usuario revisar periódicamente estas condiciones para estar al tanto de los cambios.</p>

        <h2>2. Acceso al sitio</h2>
        <p>El acceso al sitio web está permitido de forma temporal, y nos reservamos el derecho de retirar o modificar el servicio sin previo aviso. No seremos responsables si, por cualquier razón, el sitio web no está disponible en algún momento o durante algún período.</p>

        <h2>3. Uso del contenido</h2>
        <p>El contenido de la Biblioteca de Cine, incluidos los textos, imágenes, vídeos y otros materiales, es propiedad exclusiva de nuestros proveedores y está protegido por las leyes de derechos de autor. Queda estrictamente prohibido el uso no autorizado de cualquier material presente en el sitio.</p>

        <h2>4. Registro de usuarios</h2>
        <p>Para acceder a ciertas funciones del sitio, los usuarios pueden necesitar registrarse. El usuario se compromete a proporcionar información veraz, precisa, actualizada y completa durante el proceso de registro y a mantener la confidencialidad de su cuenta.</p>

        <h2>5. Responsabilidad del usuario</h2>
        <p>El usuario se compromete a utilizar el sitio de conformidad con todas las leyes aplicables y con las condiciones de uso. El usuario es el único responsable de su actividad en el sitio y de cualquier contenido que suba o comparta.</p>

        <h2>6. Prohibiciones</h2>
        <ul>
            <li>No realizar actividades que puedan dañar, deshabilitar, sobrecargar o deteriorar el sitio.</li>
            <li>No realizar actividades que infrinjan los derechos de propiedad intelectual de terceros.</li>
            <li>No utilizar el sitio para fines ilícitos, fraudulentos o no autorizados.</li>
        </ul>

        <h2>7. Enlaces a sitios de terceros</h2>
        <p>Este sitio puede contener enlaces a otros sitios web que no están bajo nuestro control. No somos responsables de los contenidos o prácticas de privacidad de esos sitios y no respaldamos ni somos responsables de los servicios ofrecidos en dichos sitios.</p>

        <h2>8. Limitación de responsabilidad</h2>
        <p>En la medida máxima permitida por la ley, no seremos responsables por ningún daño directo, indirecto, incidental, especial, consecuente o punitivo que resulte del uso de este sitio web.</p>

        <h2>9. Modificaciones de las condiciones</h2>
        <p>Nos reservamos el derecho de modificar estas condiciones de uso en cualquier momento. Las modificaciones serán efectivas a partir de su publicación en esta página. Se recomienda que los usuarios revisen regularmente las condiciones para mantenerse informados sobre cualquier cambio.</p>

        <h2>10. Ley aplicable y jurisdicción</h2>
        <p>Estas condiciones de uso se regirán e interpretarán de acuerdo con las leyes del país en el que operamos. Cualquier disputa relacionada con el uso de este sitio se someterá a la jurisdicción exclusiva de los tribunales competentes en dicho país.</p>
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


</body>

</html>