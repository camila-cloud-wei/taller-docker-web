<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = htmlspecialchars($_POST['correo']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $tipo_consulta = htmlspecialchars($_POST['tipo_consulta']);
    $area = isset($_POST['area']) ? implode(", ", $_POST['area']) : "";
    $mensaje = htmlspecialchars($_POST['mensaje']);

    if (!empty($nombre) && !empty($correo) && !empty($telefono) && !empty($tipo_consulta) && !empty($mensaje)) {
        try {
            $sql = "INSERT INTO mensajes (nombre, correo, telefono, tipo_consulta, area, mensaje) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nombre, $correo, $telefono, $tipo_consulta, $area, $mensaje]);
            $message = "<div class='alert success'>✅ Mensaje guardado correctamente.</div>";
        } catch (PDOException $e) {
            $message = "<div class='alert error'>❌ Error al guardar el mensaje: " . $e->getMessage() . "</div>";
        }
    } else {
        $message = "<div class='alert warning'>⚠️ Por favor, completa todos los campos obligatorios.</div>";
    }
}

$stmt = $conn->query("SELECT * FROM mensajes ORDER BY fecha DESC");
$mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Cloud Architects - Contenedores Docker</title>
    <link rel='stylesheet' href='style.css'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <div class="logo-icon">☁️</div>
                <h1>Cloud Architects</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#form-section">Contacto</a></li>
                    <li><a href="#table-section">Mensajes</a></li>
                    <li><a href="#about">Nosotros</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class='hero'>
            <div class="hero-content">
                <h2>🌐 Taller de Arquitectura Cloud</h2>
                <p>Contenedores con Docker y PHP + MySQL</p>
            </div>
        </section>

        <section id='form-section' class='form-section'>
            <div class="section-header">
                <h3>📝 Enviar mensaje</h3>
                <p>Complete el formulario y nos pondremos en contacto</p>
            </div>
            
            <?= $message ?>
            
            <form method='POST' id="contactForm" novalidate>
                <div class="form-row">
                    <div class="form-group">
                        <label for='nombre'>Nombre completo *</label>
                        <div class="input-container">
                            <input type='text' name='nombre' id='nombre' placeholder='Tu nombre completo' required>
                            <span class="validation-icon"></span>
                        </div>
                        <span class="error-message" id="nombre-error"></span>
                    </div>

                    <div class="form-group">
                        <label for='correo'>Correo electrónico *</label>
                        <div class="input-container">
                            <input type='email' name='correo' id='correo' placeholder='ejemplo@correo.com' required>
                            <span class="validation-icon"></span>
                        </div>
                        <span class="error-message" id="correo-error"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for='telefono'>Teléfono *</label>
                        <div class="input-container">
                            <input type='tel' name='telefono' id='telefono' placeholder='+34 600 123 456' required>
                            <span class="validation-icon"></span>
                        </div>
                        <span class="error-message" id="telefono-error"></span>
                    </div>

                    <div class="form-group">
                        <label for='tipo_consulta'>Tipo de consulta *</label>
                        <div class="input-container">
                            <select name='tipo_consulta' id='tipo_consulta' required>
                                <option value=''>Seleccione una opción</option>
                                <option value='Soporte técnico'>Soporte técnico</option>
                                <option value='Consulta general'>Consulta general</option>
                                <option value='Ventas'>Ventas</option>
                                <option value='Otros'>Otros</option>
                            </select>
                            <span class="validation-icon"></span>
                        </div>
                        <span class="error-message" id="tipo_consulta-error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Área/Categoría de interés</label>
                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type='checkbox' name='area[]' value='Desarrollo'>
                            <span class="checkmark"></span>
                            Desarrollo
                        </label>
                        <label class="checkbox-label">
                            <input type='checkbox' name='area[]' value='Infraestructura'>
                            <span class="checkmark"></span>
                            Infraestructura
                        </label>
                        <label class="checkbox-label">
                            <input type='checkbox' name='area[]' value='Cloud'>
                            <span class="checkmark"></span>
                            Cloud
                        </label>
                        <label class="checkbox-label">
                            <input type='checkbox' name='area[]' value='Seguridad'>
                            <span class="checkmark"></span>
                            Seguridad
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for='mensaje'>Mensaje *</label>
                    <div class="input-container">
                        <textarea name='mensaje' id='mensaje' rows='5' placeholder='Escribe tu mensaje...' required></textarea>
                        <span class="validation-icon"></span>
                    </div>
                    <span class="error-message" id="mensaje-error"></span>
                </div>

                <button type='submit' class="btn-primary">
                    <span class="btn-text">Enviar mensaje</span>
                    <span class="btn-icon">📨</span>
                </button>
            </form>
        </section>

        <section id='table-section' class='table-section'>
            <div class="section-header">
                <h3>📋 Mensajes registrados</h3>
                <p>Historial de contactos recibidos</p>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Tipo Consulta</th>
                            <th>Área</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($mensajes) > 0): ?>
                            <?php foreach ($mensajes as $fila): ?>
                                <tr>
                                    <td><?= $fila['id'] ?></td>
                                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                                    <td><?= htmlspecialchars($fila['correo']) ?></td>
                                    <td><?= htmlspecialchars($fila['telefono']) ?></td>
                                    <td><?= htmlspecialchars($fila['tipo_consulta']) ?></td>
                                    <td><?= htmlspecialchars($fila['area']) ?></td>
                                    <td class="mensaje-cell"><?= htmlspecialchars($fila['mensaje']) ?></td>
                                    <td><?= $fila['fecha'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan='8' class='no-data'>
                                    <div class="no-data-content">
                                        <span>📭</span>
                                        <p>No hay mensajes registrados aún</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="about" class="about-section">
            <div class="section-header">
                <h3>👥 Nuestro Equipo</h3>
                <p>Expertos en arquitecturas cloud y contenedores</p>
            </div>
            <div class="team-info">
                <p><strong>Docente:</strong> Juan Carlos López Henao</p>
                <p><strong>Especialidad:</strong> Docker, Kubernetes, Cloud Architecture</p>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <div class="logo">
                    <div class="logo-icon">☁️</div>
                    <h3>Cloud Architects</h3>
                </div>
                <p>Líderes en soluciones cloud innovadoras y arquitecturas escalables.</p>
            </div>
            
            <div class="footer-section">
                <h4>Contacto</h4>
                <p>📧 info@cloudarchitects.com</p>
                <p>📞 +34 900 123 456</p>
                <p>📍 Madrid, España</p>
            </div>
            
            <div class="footer-section">
                <h4>Síguenos</h4>
                <div class="social-links">
                    <a href="#" class="social-link">🐦 Twitter</a>
                    <a href="#" class="social-link">💼 LinkedIn</a>
                    <a href="#" class="social-link">📷 Instagram</a>
                    <a href="#" class="social-link">📘 Facebook</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 Cloud Architects Team — Docente: Juan Carlos López Henao</p>
        </div>
    </footer>

    <script src='script.js'></script>
</body>
</html>