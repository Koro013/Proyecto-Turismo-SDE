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

<main style="max-width: 1000px; margin: auto;">
    <h2><?= $destino['Nombre'] ?></h2>
    <img src="/Oficina-turismo/assets/images/<?= $destino['ImagenDelLugar'] ?>" alt="<?= $destino['Nombre'] ?>" width="100%">
    
    <p style="margin-top: 15px;"><?= $destino['descripcion'] ?></p>


    <h3>Ubicación</h3>
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
          <p style="text-align: center; margin-top: 10px;">
        <a href="https://www.google.com/maps/search/?api=1&query=<?= $destino['Latitud'] ?>,<?= $destino['Longitud'] ?>" target="_blank" class="btn">
            🌍 Ver en Google Maps
        </a>
    </p>
<?php endif; ?>

        
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
