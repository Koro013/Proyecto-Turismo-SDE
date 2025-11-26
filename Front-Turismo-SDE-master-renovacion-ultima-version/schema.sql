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
    categoria VARCHAR(100),
    CONSTRAINT uniq_destino_nombre UNIQUE (nombre)
);

CREATE TABLE recorridos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  descripcion TEXT,
  imagen TEXT
);

CREATE TABLE recorrido_destinos (
  recorrido_id INT,
  destino_id INT,
  PRIMARY KEY(recorrido_id,destino_id),
  FOREIGN KEY(recorrido_id) REFERENCES recorridos(id),
  FOREIGN KEY(destino_id) REFERENCES destinos(id)
);

INSERT INTO destinos (nombre, descripcion, horario, costo, duracion, duracion_texto, costo_texto, accesibilidad, imagen, enlace, latitud, longitud, categoria) VALUES
('Estadio Único Madre de Ciudades', 'Recinto deportivo moderno.', '09:00-20:00', 0.00, 60, '60 min', 'Gratuito', '♿ Total', 'img/estadio-unico.jpg', NULL, -27.765857312744114, -64.2704190798279, 'Deportivo'),
('Cancha de Hockey', 'Estadio de hockey provincial.', '08:00-19:00', 0.00, 45, '45 min', 'Gratuito', '♿ Parcial', 'img/cancha-hockey.jpg', NULL, -27.78514000546003, -64.24268584305663, 'Deportivo'),
('Complejo Juan Felipe Ibarra', 'Complejo de oficinas gubernamentales.', '09:00-18:00', 0.00, 30, '30 min', 'Gratuito', '♿ Total', 'img/complejo-juan-felipe-ibarra.jpg', NULL, -27.789046133359992, -64.25937655331974, 'Cultural'),

('Parque Aguirre', 'Espacio verde tradicional ideal para caminatas y aire libre', NULL, 0.00, 68, '45–90 min', 'Gratuito', '♿ Total', 'img/parque-aguirre.jpg', 'https://maps.google.com/?cid=14946438569306428049', -27.788507289907763, -64.25094016441783, 'Naturaleza'),
('Costanera del Río Dulce', 'Paseo costero con vistas al río, ideal para bici o atardecer', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Total', 'img/costanera-rio-dulce.jpg', 'https://maps.google.com/?cid=5827790631492247797', -27.780917594625503, -64.24342345516942, 'Naturaleza'),

('Patio del Indio Froilán', 'Centro cultural popular con música y gastronomía local', NULL, 0.00, 90, '60–120 min', 'Entrada gratuita o consumo', '♿ Parcial', 'img/froilan.png', 'https://maps.google.com/?cid=15796676000722884118', -27.75156406831833, -64.28963381654012, 'Cultura'),
('Casa Argañaraz Alcorta', 'Museo histórico y cultural en una casona colonial restaurada', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Parcial', 'img/casa-arganaraz-alcorta.jpg', 'https://maps.google.com/?cid=11977439877947723389', -27.785120251765743, -64.25734983925332, 'Cultura'),
('Centro Cultural del Bicentenario', 'Complejo cultural con museo, exposiciones y arte regional', NULL, 0.00, 75, '60–90 min', 'Gratuito', '♿ Total', 'img/centro-cultural-bicentenario.jpg', 'https://maps.google.com/?cid=10339264014242518200', -27.784972384816243, -64.25728978770444, 'Cultura'),

('Catedral Basílica', 'Templo histórico con fachada neoclásica', NULL, 0.00, 38, '30–45 min', 'Gratuito', '♿ Parcial', 'img/catedral-basilica.jpg', 'https://maps.google.com/?cid=3120809144550491858', -27.78823900976168, -64.26067681674726, 'Historia'),
('Museo Wagner', 'Museo con piezas arqueológicas y de arte religioso', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Parcial', 'img/museo-wagner.jpg', 'https://maps.google.com/?cid=17836876789048961976', -27.787036788653353, -64.25997612689767, 'Historia'),
('Casa de la Historia', 'Espacio dedicado a la memoria y patrimonio provincial', NULL, 0.00, 38, '30–45 min', 'Gratuito', '♿ Total', 'img/casa-de-la-historia.jpg', 'https://maps.google.com/?cid=7577025725672270341', -27.78837710934496, -64.2498004835354, 'Historia'),
('Biblioteca Di Lullo', 'Biblioteca histórica y archivo cultural', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Parcial', 'img/biblioteca-di-lullo.jpg', 'https://maps.google.com/?cid=595922326956630000', -27.79115272771976, -64.24296767754788, 'Historia'),
('Iglesia Santo Domingo', 'Iglesia de estilo colonial con valor arquitectónico', NULL, 0.00, 38, '30–45 min', 'Gratuito', '♿ Parcial', 'img/iglesia-santo-domingo.jpg', 'https://maps.app.goo.gl/qMGc48HMmmFEmdca8', -27.78811543316808, -64.25445348387399, 'Historia'),
('Complejo Juan Felipe Ibarra (mirador)', 'Centro administrativo con mirador panorámico', NULL, 0.00, 68, '45–90 min', 'Gratuito', '♿ Total', 'img/complejo-juan-felipe-ibarra.jpg', 'https://maps.google.com/?cid=11571131539400767899', -27.789240013542507, -64.25982389185843, 'Historia'), -- Mismas coord. que Complejo J. F. Ibarra

('Estadio Único Madre de Ciudades (museo)', 'Estadio moderno con museo y miradores', NULL, 0.00, 90, '60–120 min', 'Gratuito (museo con reserva)', '♿ Total', 'img/estadio-unico.jpg', 'https://maps.google.com/?cid=7643874195238516119', -27.765814615818133, -64.27059610119744, 'Deportes y Aventura'),
('La Catedral BMX', 'Circuito para BMX y deportes extremos', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ No', 'img/bmx-catedral.jpg', 'https://maps.google.com/?cid=16764608333140921443', -27.786501903454884, -64.24265538400509, 'Deportes y Aventura'),
('Kartódromo', 'Pista para karting y competencias locales', NULL, 1000.00, 60, '30–90 min', '$1000 aprox.', '♿ Parcial', 'img/kartodromo.jpg', 'https://maps.google.com/?cid=6877871856973788068', -27.780599570839698, -64.24473371189646, 'Deportes y Aventura'),
('Circuito Infantil Abierto', 'Espacio para juegos y educación vial infantil', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Total', 'img/circuito-infantil-abierto.jpg', 'https://maps.google.com/?cid=765840631397897401', -27.780547194305214, -64.25210537055209, 'Deportes y Aventura'),

('Plaza Libertad', 'Plaza central rodeada de edificios históricos', 'Todo el día', 0.00, 33, '20–45 min', 'Gratuito', '♿ Total', 'img/plaza-libertad.jpg', 'https://maps.google.com/?cid=7148757555606123814', -27.787523858100972, -64.25950245502393, 'Plazas'),
('Parque del Encuentro', 'Parque moderno con zonas de recreación y eventos', NULL, 0.00, 45, '30–60 min', 'Gratuito', '♿ Total', 'img/parque-del-encuentro.jpg', 'https://maps.google.com/?cid=9728406006659755144', -27.783236564125147, -64.24906009721511, 'Plazas'),

('Natatorio Olímpico', 'Complejo deportivo con piscina olímpica y gimnasio', NULL, 800.00, 90, '60–120 min', '$800 entrada', '♿ Total', 'img/natatorio-olimpico.jpg', 'https://maps.google.com/?cid=14840033277584301275', -27.786588522094256, -64.24085314356861, 'Otros');

INSERT INTO recorridos (nombre, descripcion, imagen) VALUES
('Recorrido Deportivo', 'Explora los principales puntos deportivos de la ciudad.', 'pelota.svg'),
('Ruta de Naturaleza', 'Paradas para pasear entre árboles, río y aire libre', 'trigo.svg'),
('Circuito Cultural', 'Música, museos y centros culturales de la ciudad', 'cultura.svg'),
('Camino Histórico', 'Arquitectura colonial, templos y miradores icónicos', 'historia.svg'),
('Aventura Deportiva', 'Espacios para deportes, adrenalina y actividades al aire libre', 'aventura.svg'),
('Plazas y Encuentros', 'Recorrido por plazas y parques urbanos para descansar', 'plaza.svg'),
('Bienestar y Piscinas', 'Opciones techadas y acuáticas para entrenar y relajarse', 'picina.svg');

INSERT INTO recorrido_destinos (recorrido_id,destino_id) VALUES
(1,1), (1,2), (1,15), (1,16), (1,17), (1,18),
(2,4), (2,5),
(3,6), (3,7), (3,8), (3,3),
(4,9), (4,10), (4,11), (4,12), (4,13), (4,14), (4,19),
(5,15), (5,16), (5,17), (5,18), (5,21),
(6,19), (6,20),
(7,21), (7,5);

-- Limpieza defensiva por si la base existente tiene duplicados previos.
-- 1. Reasignar relaciones a la versión con id más bajo de cada destino repetido.
UPDATE recorrido_destinos rd
JOIN (
  SELECT d.id AS dup_id, t.keep_id
  FROM destinos d
  JOIN (
    SELECT nombre, MIN(id) AS keep_id
    FROM destinos
    GROUP BY nombre
    HAVING COUNT(*) > 1
  ) t ON d.nombre = t.nombre
) map ON rd.destino_id = map.dup_id
SET rd.destino_id = map.keep_id;

-- 2. Eliminar los registros duplicados dejando solo el id mínimo por nombre.
DELETE d1 FROM destinos d1
JOIN destinos d2 ON d1.nombre = d2.nombre AND d1.id > d2.id;
