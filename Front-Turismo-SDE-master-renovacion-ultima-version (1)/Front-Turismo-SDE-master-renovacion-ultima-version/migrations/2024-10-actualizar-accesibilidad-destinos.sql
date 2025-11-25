-- Actualiza la accesibilidad de destinos que estaban marcados como "No informado".
UPDATE destinos
SET accesibilidad = '♿ Total'
WHERE nombre = 'Estadio Único';

UPDATE destinos
SET accesibilidad = '♿ Parcial'
WHERE nombre = 'Cancha de Hockey';

UPDATE destinos
SET accesibilidad = '♿ Total'
WHERE nombre = 'Complejo Juan Felipe Ibarra';
