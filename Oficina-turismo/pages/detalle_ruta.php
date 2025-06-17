<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once(__DIR__ . '/../config/db.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<p style='color:red;'>Ruta no especificada.</p>";
    exit;
}

// Cargar la ruta
$stmtRuta = $pdo->prepare("SELECT * FROM rutas WHERE IdRecorrido = :id");
$stmtRuta->execute(['id' => $id]);
$ruta = $stmtRuta->fetch(PDO::FETCH_ASSOC);

if (!$ruta) {
    echo "<p style='color:red;'>Ruta no encontrada.</p>";
    exit;
}

// Obtener destinos relacionados
$stmtDestinos = $pdo->prepare("
    SELECT d.* 
    FROM rutas_lugares rl
    JOIN destinos d ON rl.IdLugar = d.IdLugar
    WHERE rl.IdRecorrido = :id
");
$stmtDestinos->execute(['id' => $id]);
$destinos = $stmtDestinos->fetchAll(PDO::FETCH_ASSOC);

// Calcular totales
$costoTotal = 0;
$latlngs = [];

foreach ($destinos as $d) {
    $costoTotal += $d['CostoDeVisita'];
    if (!empty($d['Latitud']) && !empty($d['Longitud'])) {
        $latlngs[] = [$d['Latitud'], $d['Longitud']];
    }
}
?>

<main style="max-width: 1100px; margin: auto;">
    <a href="/Oficina-turismo/pages/rutas.php" class="btn">← Volver a Rutas</a>
    <h2><?= $ruta['Nombre'] ?></h2>
    <p><strong>Descripción:</strong> <?= $ruta['Descripcion'] ?></p>
    <p><strong>Duración estimada:</strong> <?= $ruta['Duracion'] ?> min</p>
    <p><strong>Costo total:</strong> $<?= number_format($costoTotal, 2) ?></p>
    <p><strong>Edad recomendada:</strong> <?= $ruta['EdadRecomendada'] ?>+</p>

    <h3>Destinos incluidos en esta ruta</h3>
    <div class="grid">
        <?php foreach ($destinos as $d): ?>
            <div class="card">
                <img src="/Oficina-turismo/assets/images/<?= $d['ImagenDelLugar'] ?>" alt="<?= $d['Nombre'] ?>" width="300">
                <h4><?= $d['Nombre'] ?></h4>
                <p><strong>Ubicación:</strong> <?= $d['Ubicacion'] ?></p>
                <p><strong>Horario:</strong> <?= $d['Horario'] ?></p>
                <p><strong>Costo:</strong> $<?= number_format($d['CostoDeVisita'], 2) ?></p>
                <p><?= $d['descripcion'] ?? 'Descripción no disponible.' ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <h3>Mapa de la Ruta</h3>
    <?php if (!empty($latlngs)): ?>
        <div id="map" style="width: 100%; height: 500px;"></div>
    <?php else: ?>
        <p style="color: orange;">⚠️ Esta ruta no tiene coordenadas cargadas para mostrar en el mapa.</p>
    <?php endif; ?>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

<!-- Leaflet Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<?php if (!empty($latlngs)): ?>
<script>
    const map = L.map('map').setView([<?= $latlngs[0][0] ?>, <?= $latlngs[0][1] ?>], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const puntos = <?= json_encode($latlngs) ?>;
    const marcadores = puntos.map(p => L.latLng(p[0], p[1]));

    marcadores.forEach(p => L.marker(p).addTo(map));

    if (marcadores.length > 1) {
        L.polyline(marcadores, { color: 'blue' }).addTo(map);
        map.fitBounds(L.polyline(marcadores).getBounds());
    }
</script>
<?php endif; ?>
