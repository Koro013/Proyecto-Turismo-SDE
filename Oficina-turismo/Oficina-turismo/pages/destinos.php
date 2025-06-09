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

<main>
    <h2>Destinos Turísticos</h2>

    <!-- Filtro por categoría -->
    <form method="GET" style="margin-bottom: 20px; text-align:center;">
        <label for="categoria">Filtrar por categoría:</label>
        <select name="categoria" onchange="this.form.submit()">
            <option value="">-- Todas --</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['IdCategoria'] ?>" <?= $categoriaSeleccionada == $cat['IdCategoria'] ? 'selected' : '' ?>>
                    <?= $cat['Descripcion'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <div class="grid">
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
                echo "<div class='card'>";
                echo "<img src='/Oficina-turismo/assets/images/{$row['ImagenDelLugar']}' alt='{$row['Nombre']}' width='300'>";
                echo "<h3>{$row['Nombre']}</h3>";
                echo "<p><strong>Categoría:</strong> {$row['CategoriaNombre']}</p>";
                echo "<p><strong>Ubicación:</strong> {$row['Ubicacion']}</p>";
                echo "<p><strong>Horario:</strong> {$row['Horario']}</p>";
                echo "<p><strong>Costo:</strong> \$" . number_format($row['CostoDeVisita'], 2) . "</p>";
                echo "<p><strong>Edad Recomendada:</strong> {$row['EdadRecomendada']}+</p>";
                echo "<p><a href='/Oficina-turismo/pages/detalle_destino.php?id={$row['IdLugar']}' class='btn'>Ver más</a></p>";
                echo "</div>";
            }

        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error al consultar destinos: {$e->getMessage()}</p>";
        }
        ?>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
