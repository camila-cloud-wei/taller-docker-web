<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Taller Cloud</title>
<link rel="stylesheet" href="style.css">
<link href='https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap' rel='stylesheet'>
</head>
<body>
<!-- Header Compacto -->
<header class="compact-header">
    <div class="logo">
        <svg width="35" height="35" viewBox="0 0 50 50">
            <circle cx="25" cy="25" r="20" fill="#0078d7"/>
            <text x="25" y="30" text-anchor="middle" fill="white" font-size="12" font-weight="bold">G14</text>
        </svg>
        <span class="logo-text">Grupo 14</span>
    </div>
    <h1>🌐 Taller de Arquitectura Cloud</h1>
    <h2>Contenedores con Docker y PHP + MySQL</h2>
</header>

<!-- Tarjeta de Login -->
<div class="auth-card-compact">
    <h2>🔐 Iniciar sesión</h2>
    <?php if(!empty($error)) echo "<div class='alert error'>$error</div>"; ?>
    <form method="POST" class="auth-form-compact">
        <div class="form-group">
            <label>Usuario</label>
            <input type="text" name="usuario" required placeholder="Ingresa tu usuario">
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required placeholder="Ingresa tu contraseña">
        </div>
        <button type="submit">Entrar</button>
    </form>
    <div class="auth-links-compact">
        <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
    </div>
</div>

<!-- Footer Compacto -->
<footer class="compact-footer">
    <p>© 2025 Taller Docker — Docente: Juan Carlos López Henao | Desarrollado por Grupo 14</p>
</footer>
</body>
</html>