CREATE TABLE IF NOT EXISTS mensajes (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    tipo_consulta VARCHAR(50) NOT NULL,
    area TEXT,
    mensaje TEXT NOT NULL,
    sentiment_data JSON NULL ,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;