
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - CineRate</title>
    <link rel="icon" href="./Imagenes/Logo_fondo_blanco.png" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="iniciosesion.css" type="text/css">
</head>

<body>
    <main class="flex-grow-1 d-flex align-items-center">
        <div class="container my-5">
            <div class="login-container">
                <div class="cine-brand">
                    <img src="./Imagenes/Logo_fondo_blanco.png"  alt="CineRate">
                    <h2>Iniciar Sesión</h2>
                    <p class="text-muted">Accede a tu cuenta para guardar tus películas favoritas</p>
                </div>
                
                <form action="procesar_login.php" method="POST">
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
                
                    
                    <button type="submit" class="btn btn-cine w-100 mb-3">Iniciar Sesión</button>
                    
                    <div class="text-center">
                        <p class="mb-0">¿No tienes una cuenta? <a href="registrar.php" class="text-warning text-decoration-none">Regístrate</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>