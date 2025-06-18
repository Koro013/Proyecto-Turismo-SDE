<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once(__DIR__ . '/../config/db.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<p class='sde-alert-error'>Ruta no especificada.</p>";
    include(__DIR__ . '/../includes/footer.php');
    exit;
}

// Cargar la ruta
$stmtRuta = $pdo->prepare("SELECT * FROM rutas WHERE IdRecorrido = :id");
$stmtRuta->execute(['id' => $id]);
$ruta = $stmtRuta->fetch(PDO::FETCH_ASSOC);

if (!$ruta) {
    echo "<p class='sde-alert-error'>Ruta no encontrada.</p>";
    include(__DIR__ . '/../includes/footer.php');
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

// Función para imagen libre por nombre (ajusta según tus destinos)
function imagenLibrePorNombre($nombre) {
    $imagenes = [
        'Termas de Río Hondo' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=700&q=80',
        'Parque Nacional Copo' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=700&q=80',
        'Ciudad Capital' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=700&q=80',
        // Agrega más si deseas
    ];
    return $imagenes[$nombre] ?? 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=700&q=80';
}
?>

<main class="sde-detalleruta-container py-4">
    <a href="/Oficina-turismo/pages/rutas.php" class="sde-btn-volver mb-3">← Volver a Rutas</a>
    <h2 class="sde-detalleruta-titulo mb-3 text-center"><?= $ruta['Nombre'] ?></h2>
    <div class="sde-detalleruta-data">
        <p><strong>Descripción:</strong> <?= $ruta['Descripcion'] ?></p>
        <p><strong>Duración estimada:</strong> <?= $ruta['Duracion'] ?> min</p>
        <p><strong>Costo total:</strong> $<?= number_format($costoTotal, 2) ?></p>
        <p><strong>Edad recomendada:</strong> <?= $ruta['EdadRecomendada'] ?>+</p>
    </div>

    <h3 class="mt-4 sde-detalleruta-h3">Destinos incluidos en esta ruta</h3>
    <div class="sde-detalleruta-grid">
        <?php foreach ($destinos as $d): 
            $img = imagenLibrePorNombre($d['Nombre']);
        ?>
            <div class="sde-detalleruta-card">
                <img src="<?= $img ?>" alt="<?= $d['Nombre'] ?>">
                <div class="sde-detalleruta-card-content">
                    <h4><?= $d['Nombre'] ?></h4>
                    <p><strong>Ubicación:</strong> <?= $d['Ubicacion'] ?></p>
                    <p><strong>Horario:</strong> <?= $d['Horario'] ?></p>
                    <p><strong>Costo:</strong> $<?= number_format($d['CostoDeVisita'], 2) ?></p>
                    <p><?= $d['descripcion'] ?? 'Descripción no disponible.' ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h3 class="sde-detalleruta-h3">Mapa de la Ruta</h3>
    <?php if (!empty($latlngs)): ?>
        <div id="map" class="sde-mapa-ruta"></div>
    <?php else: ?>
        <p class="sde-alert-warn">⚠️ Esta ruta no tiene coordenadas cargadas para mostrar en el mapa.</p>
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
