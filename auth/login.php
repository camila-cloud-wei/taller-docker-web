<?php
require_once 'jwt.php';
include 'db.php';
$secret = getenv('JWT_SECRET') ?: 'MiSecretoSuperSeguro_ChangeMe_123';
$exp_hours = intval(getenv('JWT_EXP_HOURS') ?: '6');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = trim($_POST['usuario'] ?? '');
  $password = trim($_POST['password'] ?? '');
  $stmt = $conn->prepare("SELECT id, usuario, password_hash, rol FROM usuarios WHERE usuario = ?");
  $stmt->execute([$usuario]);
  $user = $stmt->fetch();
  if ($user && password_verify($password, $user['password_hash'])) {
    $now = time();
    $payload = ['iss' => 'auth-service', 'sub' => $user['usuario'], 'rol' => $user['rol'], 'iat' => $now, 'exp' => $now + ($exp_hours * 3600)];
    $token = jwt_encode($payload, $secret);
    setcookie('auth_token', $token, ['expires' => $payload['exp'], 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
    header('Location: http://localhost:8080/');
    exit;
  } else {
    $error = "Usuario o contraseña incorrectos.";
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Taller Cloud</title>
  <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon-16x16.png" />
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

</head>

<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <svg width="50" height="50" viewBox="0 0 50 50">
          <circle cx="25" cy="25" r="20" fill="#0078d7" />
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
    <div class="login-container">
      <div class="login-card">
        <div class="login-header">
          <h2>🔐 Iniciar sesión</h2>
          <p>Accede a tu cuenta para continuar</p>
        </div>

        <?php if (!empty($error)): ?>
          <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" class="login-form">
          <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" required autocomplete="username">
          </div>

          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required autocomplete="current-password">
          </div>

          <button type="submit" class="login-button">Entrar</button>
        </form>

        <div class="login-footer">
          <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
      </div>
    </div>
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
      <p> Camila Martínez López | Diana Paola Mopan Cabrera | Jose David Arrieta Torres | Luis Alejandro Espinal Arango</p>
    </div>
  </footer>
</body>

</html>