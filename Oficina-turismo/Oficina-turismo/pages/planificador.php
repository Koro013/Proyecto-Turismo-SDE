<?php
session_start();
require_once(__DIR__ . '/../config/db.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

// Obtener destinos con coordenadas válidas
$stmt = $pdo->query("SELECT * FROM destinos WHERE Latitud IS NOT NULL AND Longitud IS NOT NULL");
$destinos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ✅ Estilo del planificador -->
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/planificador.css">

<main class="container py-4" style="max-width: 1100px;">
    <h2 class="mb-4 text-center">🧭 Planificador de Ruta Personalizada</h2>

    <div class="destinos-grid row justify-content-center">
        <?php foreach ($destinos as $d): ?>
            <label class="destino-card">
                <input type="checkbox" class="destino"
                    data-nombre="<?= $d['Nombre'] ?>"
                    data-lat="<?= $d['Latitud'] ?>"
                    data-lng="<?= $d['Longitud'] ?>"
                    data-tiempo="60"
                    data-costo="<?= $d['CostoDeVisita'] ?>">
                <div class="contenido">
                    <img src="<?= BASE_URL ?>/assets/images/<?= $d['ImagenDelLugar'] ?>" alt="<?= $d['Nombre'] ?>">
                    <div class="info">
                        <h4><?= $d['Nombre'] ?></h4>
                        <p>$<?= number_format($d['CostoDeVisita'], 2) ?></p>
                    </div>
                </div>
            </label>
        <?php endforeach; ?>
    </div>

    <!-- 🧮 Resultados -->
    <div class="totales">
        <p><strong>Duración estimada:</strong> <span id="duracion">0</span> min</p>
        <p><strong>Costo total:</strong> $<span id="costo">0.00</span></p>

        <!-- 📄 Botón para exportar PDF -->
        <form id="formExport" method="post" action="<?= BASE_URL ?>/export/generar_pdf.php" target="_blank">
            <input type="hidden" name="lugares" id="inputLugares">
            <button type="submit" class="btn">📄 Exportar a PDF</button>
        </form>
    </div>

    <!-- 🗺️ Mapa -->
    <div id="mapWrapper">
        <h3>Mapa del recorrido</h3>
        <div id="map" class="map-container"></div>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
const map = L.map('map').setView([-27.79, -64.26], 8);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let rutaPolyline = null;
let marcadores = [];

function actualizarRuta() {
    let costoTotal = 0;
    let duracionTotal = 0;
    let puntos = [];

    // Limpiar marcadores anteriores
    marcadores.forEach(m => map.removeLayer(m));
    marcadores = [];

    document.querySelectorAll('.destino:checked').forEach(chk => {
        const lat = parseFloat(chk.dataset.lat);
        const lng = parseFloat(chk.dataset.lng);
        const costo = parseFloat(chk.dataset.costo);
        const tiempo = parseFloat(chk.dataset.tiempo);
        const nombre = chk.dataset.nombre;

        puntos.push([lat, lng]);
        costoTotal += costo;
        duracionTotal += tiempo;

        const marker = L.marker([lat, lng]).addTo(map).bindPopup(nombre);
        marcadores.push(marker);
    });

    if (rutaPolyline) map.removeLayer(rutaPolyline);
    if (puntos.length > 1) {
        rutaPolyline = L.polyline(puntos, { color: 'green' }).addTo(map);
        map.fitBounds(rutaPolyline.getBounds());
    } else if (puntos.length === 1) {
        map.setView(puntos[0], 12);
    }

    document.getElementById('costo').textContent = costoTotal.toFixed(2);
    document.getElementById('duracion').textContent = duracionTotal;
}

document.querySelectorAll('.destino').forEach(chk => {
    chk.addEventListener('change', actualizarRuta);
});

// PDF EXPORT 🖨️
document.getElementById('formExport').addEventListener('submit', function (e) {
    const lugares = [];
    let costoTotal = 0;
    let duracionTotal = 0;

    document.querySelectorAll('.destino:checked').forEach(chk => {
        lugares.push({
            nombre: chk.dataset.nombre,
            lat: parseFloat(chk.dataset.lat),
            lng: parseFloat(chk.dataset.lng),
            costo: parseFloat(chk.dataset.costo)
        });

        costoTotal += parseFloat(chk.dataset.costo);
        duracionTotal += parseFloat(chk.dataset.tiempo);
    });

    const payload = {
        lugares,
        costo_total: costoTotal,
        duracion_total: duracionTotal
    };

    document.getElementById('inputLugares').value = JSON.stringify(payload);
});
</script>
