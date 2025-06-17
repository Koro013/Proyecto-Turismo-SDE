<?php
session_start();
include('../config/db.php');
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $descripcion_en = $_POST['descripcion_en'];
    $categoria = $_POST['categoria'];
    $imagen = $_FILES['imagen']['name'];
    $ruta = "../assets/images/" . basename($imagen);

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
        $stmt = $pdo->prepare("INSERT INTO destinos (nombre, descripcion, descripcion_en, categoria, imagen)
                               VALUES (:nombre, :descripcion, :descripcion_en, :categoria, :imagen)");
        $stmt->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'descripcion_en' => $descripcion_en,
            'categoria' => $categoria,
            'imagen' => $imagen
        ]);
        echo "<p>✅ Destino agregado correctamente.</p>";
    } else {
        echo "<p>❌ Error al subir la imagen.</p>";
    }
}
?>

<h2>Agregar Destino Turístico</h2>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="nombre" placeholder="Nombre del destino" required><br>
    <textarea name="descripcion" placeholder="Descripción (Español)" required></textarea><br>
    <textarea name="descripcion_en" placeholder="Description (English)" required></textarea><br>
    <input type="text" name="categoria" placeholder="Categoría"><br>
    <input type="file" name="imagen" required><br>
    <button type="submit">Guardar</button>
</form>
