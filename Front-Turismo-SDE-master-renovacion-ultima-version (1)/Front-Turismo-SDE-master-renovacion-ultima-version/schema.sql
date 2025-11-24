DROP DATABASE IF EXISTS turismo;

CREATE DATABASE turismo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE turismo;

CREATE TABLE destinos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    horario VARCHAR(100),
    costo DECIMAL(10,2),
    duracion INT,
    duracion_texto VARCHAR(50),
    costo_texto VARCHAR(100),
    accesibilidad VARCHAR(50),
    imagen VARCHAR(255),
    enlace VARCHAR(255),
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

INSERT INTO destinos (nombre, descripcion, horario, costo, duracion, duracion_texto, costo_texto, accesibilidad, imagen, enlace, latitud, longitud, categoria) VALUES
('Estadio Único', 'Recinto deportivo moderno.', '09:00-20:00', 0.00, 60, '60 min', 'Gratuito', '♿ No informado', 'img/estadio-unico.jpg', NULL, -27.766057, -64.273412, 'Deportivo'),
('Cancha de Hockey', 'Estadio de hockey provincial.', '08:00-19:00', 0.00, 45, '45 min', 'Gratuito', '♿ No informado', 'img/cancha-hockey.jpg', NULL, -27.765000, -64.270000, 'Deportivo'),
('Complejo Juan Felipe Ibarra', 'Complejo de oficinas gubernamentales.', '09:00-18:00', 0.00, 30, '30 min', 'Gratuito', '♿ No informado', 'img/complejo-juan-felipe-ibarra.jpg', NULL, -27.787000, -64.262000, 'Cultural'),

('Parque Aguirre', 'Espacio verde tradicional ideal para caminatas y aire libre', NULL, 0.00, 68, '45–90 min', 'Gratuito', '♿ Total', 'img/parque-aguirre.jpg', 'https://maps.google.com/?cid=14946438569306428049', NULL, NULL, 'Naturaleza'),
('Costanera del Río Dulce', 'Paseo costero con vistas al río, ideal para bici o atardecer', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Total', 'img/costanera-rio-dulce.jpg', 'https://maps.google.com/?cid=5827790631492247797', NULL, NULL, 'Naturaleza'),

('Patio del Indio Froilán', 'Centro cultural popular con música y gastronomía local', NULL, 0.00, 90, '60–120 min', 'Entrada gratuita o consumo', '♿ Parcial', 'img/froilan.png', 'https://maps.google.com/?cid=15796676000722884118', NULL, NULL, 'Cultura'),
('Casa Argañaraz Alcorta', 'Museo histórico y cultural en una casona colonial restaurada', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Parcial', 'img/casa-arganaraz-alcorta.jpg', 'https://maps.google.com/?cid=11977439877947723389', NULL, NULL, 'Cultura'),
('Centro Cultural del Bicentenario', 'Complejo cultural con museo, exposiciones y arte regional', NULL, 0.00, 75, '60–90 min', 'Gratuito', '♿ Total', 'img/centro-cultural-bicentenario.jpg', 'https://maps.google.com/?cid=10339264014242518200', NULL, NULL, 'Cultura'),

('Catedral Basílica', 'Templo histórico con fachada neoclásica', NULL, 0.00, 38, '30–45 min', 'Gratuito', '♿ Parcial', 'img/catedral-basilica.jpg', 'https://maps.google.com/?cid=3120809144550491858', NULL, NULL, 'Historia'),
('Museo Wagner', 'Museo con piezas arqueológicas y de arte religioso', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Parcial', 'img/museo-wagner.jpg', 'https://maps.google.com/?cid=17836876789048961976', NULL, NULL, 'Historia'),
('Casa de la Historia', 'Espacio dedicado a la memoria y patrimonio provincial', NULL, 0.00, 38, '30–45 min', 'Gratuito', '♿ Total', 'img/casa-de-la-historia.jpg', 'https://maps.google.com/?cid=7577025725672270341', NULL, NULL, 'Historia'),
('Biblioteca Di Lullo', 'Biblioteca histórica y archivo cultural', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Parcial', 'img/biblioteca-di-lullo.jpg', 'https://maps.google.com/?cid=595922326956630000', NULL, NULL, 'Historia'),
('Iglesia Santo Domingo', 'Iglesia de estilo colonial con valor arquitectónico', NULL, 0.00, 38, '30–45 min', 'Gratuito', '♿ Parcial', 'img/iglesia-santo-domingo.jpg', 'https://maps.google.com/?cid=8293941134770962434', NULL, NULL, 'Historia'),
('Complejo Ibarra (mirador)', 'Centro administrativo con mirador panorámico', NULL, 0.00, 68, '45–90 min', 'Gratuito', '♿ Total', 'img/complejo-ibarra-mirador.jpg', 'https://maps.google.com/?cid=11571131539400767899', NULL, NULL, 'Historia'),

('Estadio Madre de Ciudades', 'Estadio moderno con museo y miradores', NULL, 0.00, 90, '60–120 min', 'Gratuito (museo con reserva)', '♿ Total', 'img/estadio-madre-de-ciudades.jpg', 'https://maps.google.com/?cid=7643874195238516119', NULL, NULL, 'Deportes y Aventura'),
('BMX Catedral', 'Circuito para BMX y deportes extremos', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ No', 'img/bmx-catedral.jpg', 'https://maps.google.com/?cid=16764608333140921443', NULL, NULL, 'Deportes y Aventura'),
('Kartódromo', 'Pista para karting y competencias locales', NULL, 1000.00, 60, '30–90 min', '$1000 aprox.', '♿ Parcial', 'img/kartodromo.jpg', 'https://maps.google.com/?cid=6877871856973788068', NULL, NULL, 'Deportes y Aventura'),
('Circuito Infantil Abierto', 'Espacio para juegos y educación vial infantil', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Total', 'img/circuito-infantil-abierto.jpg', 'https://maps.google.com/?cid=765840631397897401', NULL, NULL, 'Deportes y Aventura'),

('Plaza Libertad', 'Plaza central rodeada de edificios históricos', 'Todo el día', 0.00, 33, '20–45 min', 'Gratuito', '♿ Total', 'img/plaza-libertad.jpg', 'https://maps.google.com/?cid=7148757555606123814', -27.787000, -64.263000, 'Plazas'),
('Parque del Encuentro', 'Parque moderno con zonas de recreación y eventos', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Total', 'img/parque-del-encuentro.jpg', 'https://maps.google.com/?cid=9728406006659755144', NULL, NULL, 'Plazas'),

('Natatorio Olímpico', 'Complejo deportivo con piscina olímpica y gimnasio', NULL, 800.00, 90, '60–120 min', '$800 entrada', '♿ Total', 'img/natatorio-olimpico.jpg', 'https://maps.google.com/?cid=14840033277584301275', NULL, NULL, 'Otros');

INSERT INTO recorridos (nombre, descripcion) VALUES
('Recorrido Deportivo', 'Explora los principales puntos deportivos de la ciudad.'),
('Ruta de Naturaleza', 'Paradas para pasear entre árboles, río y aire libre'),
('Circuito Cultural', 'Música, museos y centros culturales de la ciudad'),
('Camino Histórico', 'Arquitectura colonial, templos y miradores icónicos'),
('Aventura Deportiva', 'Espacios para deportes, adrenalina y actividades al aire libre'),
('Plazas y Encuentros', 'Recorrido por plazas y parques urbanos para descansar'),
('Bienestar y Piscinas', 'Opciones techadas y acuáticas para entrenar y relajarse');

INSERT INTO recorrido_destinos (recorrido_id,destino_id) VALUES
(1,1), (1,2), (1,15), (1,16), (1,17), (1,18),
(2,4), (2,5),
(3,6), (3,7), (3,8), (3,3),
(4,9), (4,10), (4,11), (4,12), (4,13), (4,14), (4,19),
(5,15), (5,16), (5,17), (5,18), (5,21),
(6,19), (6,20),
(7,21), (7,5);
