CREATE DATABASE turismo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE turismo;

CREATE TABLE destinos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    horario VARCHAR(100),
    costo DECIMAL(10,2),
    duracion INT,
    imagen VARCHAR(255),
    latitud DECIMAL(10,6),
    longitud DECIMAL(10,6),
    categoria VARCHAR(100)
);

CREATE TABLE recorridos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT
);

CREATE TABLE recorrido_destinos (
    recorrido_id INT,
    destino_id INT,
    PRIMARY KEY(recorrido_id,destino_id),
    FOREIGN KEY(recorrido_id) REFERENCES recorridos(id),
    FOREIGN KEY(destino_id) REFERENCES destinos(id)
);

INSERT INTO destinos (nombre, descripcion, horario, costo, duracion, imagen, latitud, longitud, categoria) VALUES
('Estadio \u00danico', 'Recinto deportivo moderno.', '09:00-20:00', 0.00, 60, './img/estadio-unico.jpg', -27.766057, -64.273412, 'Deportivo'),
('Cancha de Hockey', 'Estadio de hockey provincial.', '08:00-19:00', 0.00, 45, './img/estadiode-hockey.jpg', -27.765000, -64.270000, 'Deportivo'),
('Complejo Juan Felipe Ibarra', 'Complejo de oficinas gubernamentales.', '09:00-18:00', 0.00, 30, './img/las-torres.jpg', -27.787000, -64.262000, 'Cultural'),
('Plaza Libertad', 'Plaza principal de la ciudad.', 'Todo el d\u00eda', 0.00, 30, './img/plaza-libertad.jpg', -27.787000, -64.263000, 'Cultural');

INSERT INTO recorridos (nombre, descripcion) VALUES
('Recorrido Deportivo', 'Explora los principales puntos deportivos de la ciudad.');

INSERT INTO recorrido_destinos (recorrido_id,destino_id) VALUES
(1,1),
(1,2);
