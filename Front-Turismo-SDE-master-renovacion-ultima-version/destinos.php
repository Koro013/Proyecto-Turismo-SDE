<?php
require 'db.php';
$categoria = $_GET['categoria'] ?? '';
if ($categoria) {
  $stmt = $pdo->prepare('SELECT * FROM destinos WHERE categoria = ?');
  $stmt->execute([$categoria]);
} else {
  $stmt = $pdo->query('SELECT * FROM destinos');
}
$destinos = $stmt->fetchAll();
$catStmt = $pdo->query('SELECT DISTINCT categoria FROM destinos');
$categorias = $catStmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include_once('layout\links_head.html'); ?>
</head>

<body class="bg-body bebas-neue-regular">
  <header class="pb-3">
    
    <?php include_once("./layout/nav_bar.html"); ?>

  </header>

  <main class="container pt-5 mt-5">
    <form method="get" class="row mb-4">
      <div class="col-auto">
        <select name="categoria" class="form-select">
          <option value="">Todas las categorías</option>
          <?php foreach ($categorias as $c): ?>
            <option value="<?= htmlspecialchars($c) ?>" <?= $c == $categoria ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Filtrar</button>
      </div>
    </form>
    <section class="row justify-content-start ms-0 me-0">
      <?php foreach ($destinos as $d): ?>
        <?php
        $imagen = (!empty($d['imagen']) && file_exists($d['imagen'])) ? $d['imagen'] : 'img/santiago-logo.png';
        $duracionLabel = $d['duracion_texto'] ?? '';
        if (!$duracionLabel && !empty($d['duracion'])) {
          $duracionLabel = (int)$d['duracion'] . ' min';
        }
        $costoLabel = $d['costo_texto'] ?? '';
        if (!$costoLabel) {
          $costoLabel = '$' . number_format((float)$d['costo'], 2);
        }
        ?>
        <a href="destino.php?id=<?= $d['id'] ?>" class="text-decoration-none text-dark col-lg-4 p-0 me-lg-0 px-lg-2 mb-lg-3 mb-3 col-md-12">
          <div class="card btn btn-light h-100">
            <img src="<?= $imagen ?>" class="card-img-top tarjeta-imagen" alt="<?= htmlspecialchars($d['nombre']) ?>">
            <div class="card-body">
              <p class="card-text fs-3 mb-1"><?= htmlspecialchars($d['nombre']) ?></p>
              <p class="roboto-300 mb-1">Duración: <?= htmlspecialchars($duracionLabel) ?></p>
              <p class="roboto-300 mb-1">Costo: <?= htmlspecialchars($costoLabel) ?></p>
              <?php if (!empty($d['accesibilidad'])): ?>
                <span class="badge text-bg-secondary"><?= htmlspecialchars($d['accesibilidad']) ?></span>
              <?php endif; ?>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </section>
  </main>

  <?php include_once('./layout/footer.html'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>