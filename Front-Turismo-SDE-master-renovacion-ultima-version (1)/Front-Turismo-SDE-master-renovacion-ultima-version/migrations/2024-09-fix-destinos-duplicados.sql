-- Normaliza destinos duplicados y evita que se vuelvan a generar.

-- 1) Reasignar referencias de recorrido_destinos al id más bajo por nombre.
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

-- 2) Borrar destinos duplicados dejando solo el registro con id mínimo por nombre.
DELETE d1 FROM destinos d1
JOIN destinos d2 ON d1.nombre = d2.nombre AND d1.id > d2.id;

-- 3) Evitar que vuelvan a insertarse duplicados.
ALTER TABLE destinos
  ADD CONSTRAINT uniq_destino_nombre UNIQUE (nombre);
