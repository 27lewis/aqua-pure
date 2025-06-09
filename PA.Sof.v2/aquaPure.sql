CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('usuario', 'moderador') NOT NULL DEFAULT 'usuario',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Mensajes del formulario de contacto
CREATE TABLE contactos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(100) NOT NULL,
  comentario TEXT NOT NULL,
  valoracion TINYINT DEFAULT NULL,
  estado ENUM('nuevo', 'respondido', 'resuelto') DEFAULT 'nuevo',
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Respuestas a mensajes de contacto (moderador)
CREATE TABLE respuestas_contacto (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mensaje_id INT NOT NULL,
  moderador_id INT NOT NULL,
  respuesta TEXT NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (mensaje_id) REFERENCES contactos(id) ON DELETE CASCADE,
  FOREIGN KEY (moderador_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE foro_hilos (
    id INT AUTO_INCREMENT PRIMARY KEY, -- This is the primary key being referenced
    titulo VARCHAR(200) NOT NULL,
    contenido TEXT NOT NULL,
    user_id INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE foro_respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hilo_id INT NOT NULL, -- This is the foreign key!
    user_id INT NOT NULL,
    contenido TEXT NOT NULL,
    es_moderador BOOLEAN DEFAULT FALSE,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hilo_id) REFERENCES foro_hilos(id) ON DELETE CASCADE, -- Here it is!
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- These lines were outside any CREATE TABLE statement in your original file.
-- They are valid independently, but ensure they are after the table definitions.
CREATE INDEX idx_fecha_creacion ON foro_hilos (fecha_creacion DESC);
CREATE INDEX idx_usuario_id ON foro_hilos (user_id);


