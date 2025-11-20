<?php
require 'db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM destinos WHERE id = ?');
$stmt->execute([$id]);
$dest = $stmt->fetch();
if (!$dest) {
  die('Destino no encontrado');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($dest['nombre']) ?> - Turismo</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <?php include_once('layout\links_head.html'); ?>
</head>

<body class="bg-body bebas-neue-regular">
  <header class="pb-3">

    <?php include_once("./layout/nav_bar.html"); ?>
  
  </header>
  <main class="container pt-5 mt-5 mb-5">
    <div class="row mb-5 pb-5">
      <div class="col-md-6">
        <img src="<?= $dest['imagen'] ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($dest['nombre']) ?>">
      </div>
      <div class="col-md-6">
        <h1 class="mb-3" style="font-size:3em;"><?= htmlspecialchars($dest['nombre']) ?></h1>
        <h2><?= htmlspecialchars($dest['descripcion']) ?></h2>
        <h4><strong>Categoría:</strong> <?= htmlspecialchars($dest['categoria']) ?></h4>
        <h4><strong>Horario:</strong> <?= htmlspecialchars($dest['horario']) ?></h4>
        <h4><strong>Duración:</strong> <?= (int)$dest['duracion'] ?> min</h4>
        <h4><strong>Costo:</strong> $<?= number_format($dest['costo'], 2) ?></h4>
      </div>
    </div>
    <div id="map" style="height:400px"></div>
  </main>
  
  <?php include_once('./layout/footer.html'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    const map = L.map('map').setView([<?= $dest['latitud'] ?>, <?= $dest['longitud'] ?>], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    L.marker([<?= $dest['latitud'] ?>, <?= $dest['longitud'] ?>]).addTo(map);
  </script>
</body>

</html>