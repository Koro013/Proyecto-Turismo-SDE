<?php
session_start();
include('../config/db.php');
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID de destino inválido.");
}

// Obtener datos actuales del destino
$stmt = $pdo->prepare("SELECT * FROM destinos WHERE id = ?");
$stmt->execute([$id]);
$destino = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$destino) {
    die("Destino no encontrado.");
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $descripcion_en = $_POST['descripcion_en'];
    $categoria = $_POST['categoria'];

    // Si hay nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $ruta = "../assets/images/" . basename($imagen);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    } else {
        $imagen = $destino['imagen'];
    }

    $stmt = $pdo->prepare("UPDATE destinos 
        SET nombre = :nombre, descripcion = :descripcion, descripcion_en = :descripcion_en, categoria = :categoria, imagen = :imagen 
        WHERE id = :id");

    $stmt->execute([
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'descripcion_en' => $descripcion_en,
        'categoria' => $categoria,
        'imagen' => $imagen,
        'id' => $id
    ]);

    echo "<p>✅ Destino actualizado correctamente.</p>";
    $destino = array_merge($destino, $_POST); // refrescar valores
    $destino['imagen'] = $imagen;
}
?>

<h2>Editar Destino: <?= htmlspecialchars($destino['nombre']) ?></h2>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="nombre" value="<?= htmlspecialchars($destino['nombre']) ?>" required><br>
    <textarea name="descripcion" required><?= htmlspecialchars($destino['descripcion']) ?></textarea><br>
    <textarea name="descripcion_en" required><?= htmlspecialchars($destino['descripcion_en']) ?></textarea><br>
    <input type="text" name="categoria" value="<?= htmlspecialchars($destino['categoria']) ?>"><br>
    <p>Imagen actual: <?= $destino['imagen'] ?></p>
    <input type="file" name="imagen"><br>
    <button type="submit">Actualizar</button>
</form>
