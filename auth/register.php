<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario=trim($_POST['usuario']??''); $password=trim($_POST['password']??'');
  if ($usuario===''||$password===''){ $error="Completa usuario y contraseña."; }
  else {
    try { $hash=password_hash($password,algo: PASSWORD_BCRYPT); $stmt=$conn->prepare("INSERT INTO usuarios (usuario, password_hash) VALUES (?, ?)"); $stmt->execute([$usuario,$hash]); header('Location: login.php'); exit; }
    catch(PDOException $e){ $error="No se pudo registrar (¿usuario ya existe?)."; }
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro - Taller Cloud</title>
<link rel="icon" type="image/png" sizes="16x16" href="assets/favicon-16x16.png"/>
<link rel="stylesheet" href="style.css">
<link href='https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap' rel='stylesheet'>
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo">
            <svg width="50" height="50" viewBox="0 0 50 50">
                <circle cx="25" cy="25" r="20" fill="#0078d7"/>
                <text x="25" y="30" text-anchor="middle" fill="white" font-size="14" font-weight="bold">G14</text>
            </svg>
            <span class="logo-text">Grupo 14</span>
        </div>
        <div class="header-titles">
            <h1>🐋 Taller de Arquitectura Cloud</h1>
            <h2>Contenedores con Docker y PHP + MySQL</h2>
        </div>
    </div>
</header>

<main>
    <section class="form-section">
        <h3>🧾 Registro de usuario</h3>
        <?php if(!empty($error)) echo "<div class='alert error'>$error</div>"; ?>
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" required placeholder="Ingresa tu usuario">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required placeholder="Ingresa tu contraseña">
            </div>
            <div class="form-actions">
                <button type="submit">Registrar</button>
            </div>
        </form>
        <div class="auth-links">
            <p><a href="login.php">Volver al login</a></p>
        </div>
    </section>
</main>

<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h4>Contacto</h4>
            <p>Email: info@grupo14.com</p>
            <p>Teléfono: +1 234 567 890</p>
        </div>
        <div class="footer-section">
            <h4>Enlaces</h4>
            <a href="#">Política de Privacidad</a>
            <a href="#">Términos de Uso</a>
            <a href="#">Soporte</a>
        </div>
        <div class="footer-section">
            <h4>Grupo 14</h4>
            <p>Especialistas en Arquitectura Cloud</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> G14 Cloud Architects Team. Todos los derechos reservados.</p>
        <p>Camila Martínez López | Diana Paola Mopan Cabrera | Jose David Arrieta Torres | Luis Alejandro Espinal Arango</p>
    </div>
</footer>
</body>
</html>
