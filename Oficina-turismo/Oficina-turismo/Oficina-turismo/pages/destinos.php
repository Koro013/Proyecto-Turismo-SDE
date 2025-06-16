<?php 
session_start();
require_once(__DIR__ . '/../config/db.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

// Categoría seleccionada vía GET
$categoriaSeleccionada = $_GET['categoria'] ?? '';

// Cargar categorías para el select
$categorias = [];
try {
    $catStmt = $pdo->query("SELECT * FROM categorias");
    $categorias = $catStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Error cargando categorías: {$e->getMessage()}</p>";
}
?>

<main class="container py-4">
    <h2 class="mb-4 text-center">Destinos Turísticos</h2>

    <!-- Filtro por categoría -->
    <form method="GET" class="row mb-4 justify-content-center">
        <label for="categoria" class="col-auto col-form-label">Filtrar por categoría:</label>
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

    <div class="grid row row-cols-1 row-cols-md-3 g-4">
        <?php
        try {
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
                echo "<div class='card tarjeta-destinos h-100 text-center shadow-sm'>";
                echo "    <img class='card-img-top tarjeta-imagen' src='/Oficina-turismo/assets/images/{$row['ImagenDelLugar']}' alt='{$row['Nombre']}'>";
                echo "    <div class='card-body'>";
                echo "        <h3 class='card-title h5 bebas-neue-regular mb-2'>{$row['Nombre']}</h3>";
                echo "        <p class='card-text'><strong>Categoría:</strong> {$row['CategoriaNombre']}</p>";
                echo "        <p class='card-text'><strong>Ubicación:</strong> {$row['Ubicacion']}</p>";
                echo "        <p class='card-text'><strong>Horario:</strong> {$row['Horario']}</p>";
                echo "        <p class='card-text'><strong>Costo:</strong> \$" . number_format($row['CostoDeVisita'], 2) . "</p>";
                echo "        <p class='card-text'><strong>Edad Recomendada:</strong> {$row['EdadRecomendada']}+</p>";
                echo "        <a href='/Oficina-turismo/pages/detalle_destino.php?id={$row['IdLugar']}' class='btn btn-primary botones-cuerpo'>Ver más</a>";
                echo "    </div>";
                echo "</div>";
            }

        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error al consultar destinos: {$e->getMessage()}</p>";
        }
        ?>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
