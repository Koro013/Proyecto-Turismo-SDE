<?php 
session_start();
require_once(__DIR__ . '/../config/db.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$categoriaSeleccionada = $_GET['categoria'] ?? '';

// Categorías
$categorias = [];
try {
    $catStmt = $pdo->query("SELECT * FROM categorias");
    $categorias = $catStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Error cargando categorías: {$e->getMessage()}</p>";
}
?>

<main class="sde-destinos-container py-4">
  <div class="destinos-section mb-5 mx-auto">
    <!-- CARTEL SUPER LLAMATIVO -->
    <div class="row justify-content-center">
      <div class="col-auto">
        <div class="cartel-destinos-wrapper cartel-destinos-efecto">
          <span class="cartel-destinos">DESTINOS</span>
        </div>
      </div>
    </div>

    <!-- Filtro por categoría -->
    <form method="GET" class="sde-destinos-filtro row mb-4 justify-content-center align-items-center">
      <label for="categoria" class="col-auto col-form-label cartel-label">Filtrar por categoría:</label>
      <div class="col-auto">
        <select name="categoria" class="form-select" onchange="this.form.submit()">
          <option value="">-- Todas --</option>
          <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['IdCategoria'] ?>" <?= $categoriaSeleccionada == $cat['IdCategoria'] ? 'selected' : '' ?>>
              <?= $cat['Descripcion'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </form>

    <!-- Tarjetas -->
    <div class="destinos-cards d-flex flex-wrap justify-content-center align-items-stretch">
      <?php
      function imagenLibrePorNombre($nombre) {
        $imagenes = [
          'Termas de Río Hondo' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=500&q=80',
          'Parque Nacional Copo' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=500&q=80',
          'Ciudad Capital' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=500&q=80',
        ];
        return $imagenes[$nombre] ?? 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=500&q=80';
      }
      try {
        $i = 0;
        if ($categoriaSeleccionada) {
          $stmt = $pdo->prepare("
            SELECT d.*, c.Descripcion AS CategoriaNombre 
            FROM destinos d 
            INNER JOIN categorias c ON d.IdCategoria = c.IdCategoria 
            WHERE d.IdCategoria = :id
          ");
          $stmt->execute(['id' => $categoriaSeleccionada]);
        } else {
          $stmt = $pdo->query("
            SELECT d.*, c.Descripcion AS CategoriaNombre 
            FROM destinos d 
            INNER JOIN categorias c ON d.IdCategoria = c.IdCategoria
          ");
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $imgUrl = imagenLibrePorNombre($row['Nombre']);
          // FadeInUp staggered
          $delay = $i * 90;
          echo "<div class='destino-card-modern card text-center m-3' style='animation-delay: {$delay}ms;'>";
          echo "<img src='{$imgUrl}' alt='{$row['Nombre']}' class='card-img-top'>";
          echo "<div class='card-body'>";
          echo "<p class='card-title'>{$row['Nombre']}</p>";
          echo "<p class='sde-cat'><strong>Categoría:</strong> {$row['CategoriaNombre']}</p>";
          echo "<p><strong>Ubicación:</strong> {$row['Ubicacion']}</p>";
          echo "<p><strong>Horario:</strong> {$row['Horario']}</p>";
          echo "<p><strong>Costo:</strong> \$" . number_format($row['CostoDeVisita'], 2) . "</p>";
          echo "<p><strong>Edad Recomendada:</strong> {$row['EdadRecomendada']}+</p>";
          echo "<p><a href='/Oficina-turismo/pages/detalle_destino.php?id={$row['IdLugar']}' class='sde-btn-destino'>Ver más</a></p>";
          echo "</div>";
          echo "</div>";
          $i++;
        }

      } catch (PDOException $e) {
        echo "<p style='color:red;'>Error al consultar destinos: {$e->getMessage()}</p>";
      }
      ?>
    </div>
  </div>
</main>
