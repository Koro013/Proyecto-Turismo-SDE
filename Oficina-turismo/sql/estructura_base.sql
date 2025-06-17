CREATE DATABASE turismo_santiago CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE turismo_santiago;

-- Tabla de destinos turísticos
CREATE TABLE destinos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    descripcion_en TEXT,
    categoria VARCHAR(100),
    imagen VARCHAR(255)
);


-- Tabla de rutas
CREATE TABLE rutas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    descripcion TEXT,
    tiempo_estimado VARCHAR(50),
    dificultad VARCHAR(50)
);



-- Tabla de usuarios administradores
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Tabla de suscriptores al boletín
CREATE TABLE suscriptores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    fecha_suscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de itinerarios personalizados
CREATE TABLE itinerarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(255),
    destinos_seleccionados TEXT, -- JSON con los destinos
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
