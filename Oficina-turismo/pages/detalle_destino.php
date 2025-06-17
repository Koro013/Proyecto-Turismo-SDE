<?php
session_start();
require_once(__DIR__ . '/../config/db.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<p class='sde-alert-error'>Destino no especificado.</p>";
    include(__DIR__ . '/../includes/footer.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM destinos WHERE IdLugar = :id");
$stmt->execute(['id' => $id]);
$destino = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$destino) {
    echo "<p class='sde-alert-error'>Destino no encontrado.</p>";
    include(__DIR__ . '/../includes/footer.php');
    exit;
}

// Función para imagen libre por nombre
function imagenLibrePorNombre($nombre) {
    $imagenes = [
        'Termas de Río Hondo' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=700&q=80',
        'Parque Nacional Copo' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=700&q=80',
        'Ciudad Capital' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=700&q=80',
        // Agrega más si lo deseas
    ];
    return $imagenes[$nombre] ?? 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=700&q=80';
}

$imgLibre = imagenLibrePorNombre($destino['Nombre']);
?>

<main class="sde-detalle-container py-4">
    <div class="sde-detalle-card">
        <div class="sde-detalle-img">
            <img src="<?= $imgLibre ?>" alt="<?= $destino['Nombre'] ?>">
        </div>
        <div class="sde-detalle-content">
            <h2 class="mb-3 text-center"><?= $destino['Nombre'] ?></h2>
            <p class="mb-4"><?= $destino['descripcion'] ?></p>
            <ul class="sde-detalle-lista">
                <li><strong>Ubicación:</strong> <?= $destino['Ubicacion'] ?></li>
                <li><strong>Horario:</strong> <?= $destino['Horario'] ?></li>
                <li><strong>Costo:</strong> $<?= number_format($destino['CostoDeVisita'], 2) ?></li>
                <li><strong>Edad Recomendada:</strong> <?= $destino['EdadRecomendada'] ?>+</li>
            </ul>
        </div>
    </div>

    <!-- Mapa -->
    <?php if (!empty($destino['Latitud']) && !empty($destino['Longitud'])): ?>
        <div class="sde-mapa-box">
            <h3 class="mb-3">Ubicación en el mapa</h3>
            <div class="sde-mapa">
                <iframe
                    width="100%"
                    height="100%"
                    frameborder="0"
                    style="border:0"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=<?= $destino['Longitud'] - 0.01 ?>,<?= $destino['Latitud'] - 0.01 ?>,<?= $destino['Longitud'] + 0.01 ?>,<?= $destino['Latitud'] + 0.01 ?>&amp;layer=mapnik&amp;marker=<?= $destino['Latitud'] ?>,<?= $destino['Longitud'] ?>"
                    allowfullscreen>
                </iframe>
            </div>
            <p class="text-center mt-3">
                <a href="https://www.google.com/maps/search/?api=1&query=<?= $destino['Latitud'] ?>,<?= $destino['Longitud'] ?>" target="_blank" class="sde-btn-mapa">
                    🌍 Ver en Google Maps
                </a>
            </p>
        </div>
    <?php endif; ?>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
