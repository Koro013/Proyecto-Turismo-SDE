<?php
require 'db.php';
$destinos = $pdo->query('SELECT * FROM destinos')->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Planificador - Turismo - Santiago del Estero</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <?php include_once('layout\links_head.html'); ?>
</head>

<body class="bg-body bebas-neue-regular">
  <header class="pb-2">

    <?php include_once("./layout/nav_bar.html"); ?>
  
  </header>
  <main class="container pt-5 mt-5 mb-5">
    <h1 class="mb-4" style="font-size: 5em;">Planificador</h1>
    <form id="formDestinos" method="post" action="generar_pdf.php">
      <div class="row">
        <?php foreach ($destinos as $d): ?>
          <div class="col-md-6 mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="<?= $d['id'] ?>" id="dest<?= $d['id'] ?>" name="destinos[]" data-costo="<?= $d['costo'] ?>" data-duracion="<?= $d['duracion'] ?>" data-lat="<?= $d['latitud'] ?>" data-lon="<?= $d['longitud'] ?>">
              <label class="form-check-label" for="dest<?= $d['id'] ?>">
                <?= htmlspecialchars($d['nombre']) ?> (<?= (int)$d['duracion'] ?> min - $<?= number_format($d['costo'], 2) ?>)
              </label>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <p id="infoTotales" class="fs-4 mt-3">Duración: 0 min - Costo: $0.00</p>
      <input type="hidden" name="total_costo" id="totalCosto">
      <input type="hidden" name="total_duracion" id="totalDuracion">
      <button type="submit" class="btn btn-primary">Exportar PDF</button>
    </form>
    <div id="map" style="height: 400px" class="mt-4"></div>
  </main>

  <?php include_once('./layout/footer.html'); ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    const destinos = <?php echo json_encode($destinos); ?>;
    const mapa = L.map('map').setView([-27.78, -64.26], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(mapa);

    let markers = [];

    function actualizar() {
      let totalDur = 0;
      let totalCos = 0;
      markers.forEach(m => mapa.removeLayer(m));
      markers = [];
      document.querySelectorAll('input[name="destinos[]"]:checked').forEach(ch => {
        const lat = ch.dataset.lat;
        const lon = ch.dataset.lon;
        totalDur += parseInt(ch.dataset.duracion);
        totalCos += parseFloat(ch.dataset.costo);
        if (lat && lon) {
          const marker = L.marker([lat, lon]).addTo(mapa);
          markers.push(marker);
        }
      });
      document.getElementById('infoTotales').textContent = `Duración: ${totalDur} min - Costo: $${totalCos.toFixed(2)}`;
      document.getElementById('totalCosto').value = totalCos;
      document.getElementById('totalDuracion').value = totalDur;
    }

    document.querySelectorAll('input[name="destinos[]"]').forEach(ch => ch.addEventListener('change', actualizar));
  </script>
</body>

</html>