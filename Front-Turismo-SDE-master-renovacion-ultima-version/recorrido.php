<?php
require 'db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT nombre, descripcion FROM recorridos WHERE id = ?');
$stmt->execute([$id]);
$rec = $stmt->fetch();
if (!$rec) {
  die('Recorrido no encontrado');
}
$dstmt = $pdo->prepare('SELECT d.* FROM destinos d JOIN recorrido_destinos rd ON d.id = rd.destino_id WHERE rd.recorrido_id = ?');
$dstmt->execute([$id]);
$destinos = $dstmt->fetchAll();
$totalDur = array_sum(array_column($destinos, 'duracion'));
$totalCosto = array_sum(array_column($destinos, 'costo'));
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($rec['nombre']) ?> - Recorrido</title>
  <?php include_once('layout\links_head.html'); ?>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
</head>

<body class="bg-body bebas-neue-regular">
  <header>

    <?php include_once("./layout/nav_bar.html"); ?>
  
  </header>
  <main class="container mt-5 pt-5">
    <h1 class="mb-3" style="font-size:3em;"><?= htmlspecialchars($rec['nombre']) ?></h1>
    <p class="mb-4"><?= htmlspecialchars($rec['descripcion']) ?></p>
    <div class="row">
      <div class="col-md-6">
        <ul class="list-group mb-3">
          <?php foreach ($destinos as $d): ?>
            <li class="list-group-item">
              <strong><?= htmlspecialchars($d['nombre']) ?></strong><br>
              <?= htmlspecialchars($d['descripcion']) ?><br>
              Horario: <?= htmlspecialchars($d['horario']) ?>
              <br>Duración: <?= (int)$d['duracion'] ?> min - Costo: $<?= number_format($d['costo'], 2) ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <p><strong>Duración total:</strong> <?= (int)$totalDur ?> min</p>
        <p><strong>Costo total:</strong> $<?= number_format($totalCosto, 2) ?></p>
      </div>
      <div class="col-md-6">
        <div id="map" style="height:300px"></div>
      </div>
    </div>
  </main>
  
  <?php include_once('./layout/footer.html'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    const map = L.map('map').setView([<?php echo $destinos[0]['latitud'] ?? -27.78; ?>, <?php echo $destinos[0]['longitud'] ?? -64.26; ?>], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    <?php foreach ($destinos as $d): ?>
      L.marker([<?= $d['latitud'] ?>, <?= $d['longitud'] ?>]).addTo(map).bindPopup("<?= htmlspecialchars($d['nombre']) ?>");
    <?php endforeach; ?>
  </script>
</body>

</html>