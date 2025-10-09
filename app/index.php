<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = htmlspecialchars($_POST['correo']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $tipo_consulta = htmlspecialchars($_POST['tipo_consulta']);
    $categoria = htmlspecialchars($_POST['categoria']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    if (!empty($nombre) && !empty($correo) && !empty($telefono) && !empty($tipo_consulta) && !empty($categoria) && !empty($mensaje)) {
        try {
            $sql = "INSERT INTO mensajes (nombre, correo, telefono, tipo_consulta, categoria, mensaje) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nombre, $correo, $telefono, $tipo_consulta, $categoria, $mensaje]);
            $message = "<div class='alert success'>✅ Mensaje guardado correctamente.</div>";
        } catch (PDOException $e) {
            $message = "<div class='alert error'>❌ Error al guardar el mensaje: " . $e->getMessage() . "</div>";
        }
    } else {
        $message = "<div class='alert warning'>⚠️ Por favor, completa todos los campos.</div>";
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
<title>Arquitectura Cloud - Contenedores Docker</title>
<link rel='stylesheet' href='style.css'>
<link href='https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap' rel='stylesheet'>
<script>
function validarFormulario() {
    const nombre = document.getElementById('nombre').value.trim();
    const correo = document.getElementById('correo').value.trim();
    const telefono = document.getElementById('telefono').value.trim();
    const tipoConsulta = document.getElementById('tipo_consulta').value;
    const categoria = document.getElementById('categoria').value;
    const mensaje = document.getElementById('mensaje').value.trim();
    
    if (!nombre || !correo || !telefono || !tipoConsulta || !categoria || !mensaje) {
        alert("Por favor completa todos los campos.");
        return false;
    }
    
    if (telefono.length < 5) {
        alert("El teléfono debe tener al menos 5 dígitos.");
        return false;
    }
    
    return true;
}

function validarCampo(campo) {
    const valor = campo.value.trim();
    const errorElement = document.getElementById(campo.id + 'Error');
    
    // Remover clases previas
    campo.classList.remove('valid', 'invalid');
    
    if (campo.type === 'tel' && campo.required) {
        if (valor.length >= 5) {
            campo.classList.add('valid');
            errorElement.textContent = '';
        } else {
            campo.classList.add('invalid');
            errorElement.textContent = 'El teléfono debe tener al menos 5 dígitos.';
        }
    }
    
    if (campo.type === 'email' && campo.required) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailRegex.test(valor)) {
            campo.classList.add('valid');
            errorElement.textContent = '';
        } else {
            campo.classList.add('invalid');
            errorElement.textContent = 'Por favor ingresa un email válido.';
        }
    }
    
    if (campo.type === 'text' && campo.required && campo.id !== 'telefono') {
        if (valor.length > 0) {
            campo.classList.add('valid');
            errorElement.textContent = '';
        } else {
            campo.classList.add('invalid');
            errorElement.textContent = 'Este campo es obligatorio.';
        }
    }
    
    if (campo.tagName === 'SELECT' && campo.required) {
        if (valor !== '') {
            campo.classList.add('valid');
            errorElement.textContent = '';
        } else {
            campo.classList.add('invalid');
            errorElement.textContent = 'Este campo es obligatorio.';
        }
    }
    
    if (campo.tagName === 'TEXTAREA' && campo.required) {
        if (valor.length > 0) {
            campo.classList.add('valid');
            errorElement.textContent = '';
        } else {
            campo.classList.add('invalid');
            errorElement.textContent = 'Este campo es obligatorio.';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validarCampo(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('invalid')) {
                validarCampo(this);
            }
        });
    });
});
</script>
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
    <section class='form-section full-width'>
        <h3>📝 Formulario de Contacto</h3>
        <?= $message ?>
        <form method='POST' onsubmit='return validarFormulario();'>
            <div class="form-grid">
                <div class="form-group">
                    <label for='nombre'>Nombre:</label>
                    <input type='text' name='nombre' id='nombre' placeholder='Tu nombre completo' required>
                    <span class="error-message" id="nombreError"></span>
                </div>
                
                <div class="form-group">
                    <label for='correo'>Correo:</label>
                    <input type='email' name='correo' id='correo' placeholder='ejemplo@correo.com' required>
                    <span class="error-message" id="correoError"></span>
                </div>
                
                <div class="form-group">
                    <label for='telefono'>Teléfono:</label>
                    <input type='tel' name='telefono' id='telefono' placeholder='123456789' minlength="5" required>
                    <span class="error-message" id="telefonoError"></span>
                </div>
                
                <div class="form-group">
                    <label for='tipo_consulta'>Tipo de Consulta:</label>
                    <select name='tipo_consulta' id='tipo_consulta' required>
                        <option value=''>Selecciona una opción</option>
                        <option value='Soporte'>Soporte</option>
                        <option value='Ventas'>Ventas</option>
                        <option value='Información General'>Información General</option>
                        <option value='Otros'>Otros</option>
                    </select>
                    <span class="error-message" id="tipo_consultaError"></span>
                </div>
                
                <div class="form-group">
                    <label for='categoria'>Área/Categoría:</label>
                    <select name='categoria' id='categoria' required>
                        <option value=''>Selecciona una opción</option>
                        <option value='Académico'>Académico</option>
                        <option value='Técnico'>Técnico</option>
                        <option value='Administrativo'>Administrativo</option>
                        <option value='General'>General</option>
                    </select>
                    <span class="error-message" id="categoriaError"></span>
                </div>
                
                <div class="form-group full-width">
                    <label for='mensaje'>Mensaje:</label>
                    <textarea name='mensaje' id='mensaje' rows='5' placeholder='Escribe tu mensaje...' required></textarea>
                    <span class="error-message" id="mensajeError"></span>
                </div>
            </div>

            <div class="form-actions">
                <button type='submit'>Guardar mensaje</button>
            </div>
        </form>
    </section>

    <section class='table-section full-width'>
        <h3>📋 Mensajes registrados</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Tipo Consulta</th>
                        <th>Categoría</th>
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
                                <td><?= htmlspecialchars($fila['categoria']) ?></td>
                                <td><?= htmlspecialchars($fila['mensaje']) ?></td>
                                <td><?= $fila['fecha'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan='8' style='text-align:center;'>Sin registros aún.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
            <p> Camila Martínez López | Diana Paola Mopan Cabrera | Jose David Arrieta Torres | Luis Alejandro Espinal Arango</p>
        <p> </p>
    </div>
</footer>
<script src='script.js'></script>
</body>
</html>