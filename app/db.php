
<?php
$host = 'db';
$dbname = 'appdb';
$username = 'appuser';
$password = 'app123';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Verificar si la tabla existe
    $tableExists = $conn->query("SHOW TABLES LIKE 'mensajes'")->rowCount() > 0;
    
    if ($tableExists) {
        // Verificar si las columnas nuevas existen
        $columns = $conn->query("SHOW COLUMNS FROM mensajes")->fetchAll(PDO::FETCH_COLUMN);
        
        // Agregar columnas faltantes
        if (!in_array('telefono', $columns)) {
            $conn->exec("ALTER TABLE mensajes ADD COLUMN telefono VARCHAR(20) NOT NULL AFTER correo");
        }
        if (!in_array('tipo_consulta', $columns)) {
            $conn->exec("ALTER TABLE mensajes ADD COLUMN tipo_consulta VARCHAR(50) NOT NULL AFTER telefono");
        }
        if (!in_array('categoria', $columns)) {
            $conn->exec("ALTER TABLE mensajes ADD COLUMN categoria VARCHAR(50) NOT NULL AFTER tipo_consulta");
        }
    } else {
        // Crear la tabla completa si no existe
        $sql = "CREATE TABLE mensajes (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            correo VARCHAR(100) NOT NULL,
            telefono VARCHAR(20) NOT NULL,
            tipo_consulta VARCHAR(50) NOT NULL,
            categoria VARCHAR(50) NOT NULL,
            mensaje TEXT NOT NULL,
            fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
    }
    
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
?>