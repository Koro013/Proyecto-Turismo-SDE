<?php
session_start();
require_once(__DIR__ . '/../config/db.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<p>Destino no especificado.</p>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM destinos WHERE IdLugar = :id");
$stmt->execute(['id' => $id]);
$destino = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$destino) {
    echo "<p>Destino no encontrado.</p>";
    exit;
}
?>

<!-- Estilos específicos de la página -->
<link rel="stylesheet" href="/Oficina-turismo/assets/css/front/destino-style.css">

<main class="container py-4" style="max-width: 1000px;">
    <h2 class="mb-3 text-center"><?= $destino['Nombre'] ?></h2>
    <img src="/Oficina-turismo/assets/images/<?= $destino['ImagenDelLugar'] ?>" alt="<?= $destino['Nombre'] ?>" class="img-fluid mb-3">

    <p class="mb-4"><?= $destino['descripcion'] ?></p>


    <h3 class="mb-3">Ubicación</h3>
    <div style="width: 100%; height: 400px; margin-bottom: 20px;">
        <iframe
            width="100%"
            height="100%"
            frameborder="0"
            style="border:0"
            src="https://www.openstreetmap.org/export/embed.html?bbox=<?= $destino['Longitud'] - 0.01 ?>,<?= $destino['Latitud'] - 0.01 ?>,<?= $destino['Longitud'] + 0.01 ?>,<?= $destino['Latitud'] + 0.01 ?>&amp;layer=mapnik&amp;marker=<?= $destino['Latitud'] ?>,<?= $destino['Longitud'] ?>"
            allowfullscreen>
        </iframe>
        <?php if (!empty($destino['Latitud']) && !empty($destino['Longitud'])): ?>
          <p class="text-center mt-3">
        <a href="https://www.google.com/maps/search/?api=1&query=<?= $destino['Latitud'] ?>,<?= $destino['Longitud'] ?>" target="_blank" class="btn btn-primary">
            🌍 Ver en Google Maps
        </a>
    </p>
<?php endif; ?>

        
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
