<?php
require 'db.php';
$categoria = $_GET['categoria'] ?? '';
$sql = 'SELECT r.id, r.nombre, r.descripcion, r.imagen,
               MIN(d.categoria) AS categoria,
               SUM(d.duracion) AS duracion,
               SUM(d.costo) AS costo
        FROM recorridos r
        JOIN recorrido_destinos rd ON r.id = rd.recorrido_id
        JOIN (
          SELECT d.*
          FROM destinos d
          INNER JOIN (
            SELECT MIN(id) AS id
            FROM destinos
            GROUP BY nombre
          ) uniq ON uniq.id = d.id
        ) d ON d.id = rd.destino_id';
$params = [];
if ($categoria) {
  $sql .= ' WHERE d.categoria = ?';
  $params[] = $categoria;
}
$sql .= ' GROUP BY r.id';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$recorridos = $stmt->fetchAll();
$catStmt = $pdo->query('SELECT DISTINCT categoria FROM destinos');
$categorias = $catStmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include_once('layout/links_head.html'); ?>
</head>

<body class="bg-body bebas-neue-regular">
  <header class="pb-3">
    
    <?php include_once('./layout/nav_bar.html'); ?>

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
    <section class="row justify-content-evenly ms-1 me-1">
      <?php foreach ($recorridos as $r): ?>
        <a href="recorrido.php?id=<?= $r['id'] ?>" class="text-decoration-none text-dark col-lg-3 p-0 me-lg-3 mb-lg-3 mb-3 col-md-12">
          <div class="card btn btn-light h-100 tarjeta-recorrido">
            <img src="./img/<?= $r['imagen'] ?>" class="card-img-top p-5 tarjeta-imagen" alt="Icono">
            <div class="card-body">
              <p class="card-text fs-2 mb-1"><?= htmlspecialchars($r['nombre']) ?></p>
              <div class="roboto-300">
                <p class="card-text text-start fs-5"><strong>Duración:</strong> <?= (int)$r['duracion'] ?> min</p>
                <p class="card-text text-start fs-5"><strong>Costo:</strong> $<?= number_format($r['costo'], 2) ?></p>
                <p class="card-text text-start fs-5"><?= htmlspecialchars($r['descripcion']) ?></p>
              </div>
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