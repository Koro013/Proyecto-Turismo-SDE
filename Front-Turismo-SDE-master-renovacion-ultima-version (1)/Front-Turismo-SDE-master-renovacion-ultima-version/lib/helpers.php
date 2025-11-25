<?php

declare(strict_types=1);

/**
 * Obtiene una sola fila por nombre de destino, priorizando el id más bajo para
 * evitar duplicados que puedan existir en la base de datos.
 *
 * @param PDO $pdo       Conexión activa a la base de datos.
 * @param string $categoria Filtro opcional por categoría.
 *
 * @return array Lista de destinos sin duplicados por nombre.
 */
function fetchUniqueDestinos(PDO $pdo, string $categoria = ''): array
{
    $sql = "SELECT d.*
            FROM destinos d
            INNER JOIN (
              SELECT MIN(id) AS id
              FROM destinos
              GROUP BY nombre
            ) uniq ON uniq.id = d.id";

    $params = [];

    if ($categoria !== '') {
        $sql .= " WHERE d.categoria = ?";
        $params[] = $categoria;
    }

    $sql .= " ORDER BY d.nombre";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

/**
 * Normaliza la ruta de la imagen y devuelve un placeholder si el archivo no existe.
 */
function resolveImagePath(string $path): string
{
    $trimmed = ltrim($path, './');
    $relative = (substr($trimmed, 0, 4) === 'img/') ? $trimmed : 'img/' . $trimmed;

    $fullPath = dirname(__DIR__) . '/' . $relative;

    if (!is_file($fullPath)) {
        return './img/santiago-logo.png';
    }

    return './' . $relative;
}

