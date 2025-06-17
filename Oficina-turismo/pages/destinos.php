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

<main class="sde-destinos-container py-4">
    <h2 class="sde-destinos-titulo mb-4 text-center">Destinos Turísticos</h2>

    <!-- Filtro por categoría -->
    <form method="GET" class="sde-destinos-filtro row mb-4 justify-content-center">
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

    <div class="sde-destinos-grid">
        <?php
        // Función para elegir imagen por nombre de destino (solo ejemplos, personaliza según tu base)
        function imagenLibrePorNombre($nombre) {
            $imagenes = [
                'Termas de Río Hondo' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=500&q=80',
                'Parque Nacional Copo' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=500&q=80',
                'Ciudad Capital' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=500&q=80',
                // Agrega más mapeos aquí según tus lugares
            ];
            return $imagenes[$nombre] ?? 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=500&q=80';
        }

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
                // Usar imagen libre según el nombre
                $imgUrl = imagenLibrePorNombre($row['Nombre']);
                echo "<div class='sde-destino-card'>";
                echo "<img src='{$imgUrl}' alt='{$row['Nombre']}'>";
                echo "<div class='sde-destino-card-content'>";
                echo "<h3>{$row['Nombre']}</h3>";
                echo "<p class='sde-cat'><strong>Categoría:</strong> {$row['CategoriaNombre']}</p>";
                echo "<p><strong>Ubicación:</strong> {$row['Ubicacion']}</p>";
                echo "<p><strong>Horario:</strong> {$row['Horario']}</p>";
                echo "<p><strong>Costo:</strong> \$" . number_format($row['CostoDeVisita'], 2) . "</p>";
                echo "<p><strong>Edad Recomendada:</strong> {$row['EdadRecomendada']}+</p>";
                echo "<p><a href='/Oficina-turismo/pages/detalle_destino.php?id={$row['IdLugar']}' class='sde-btn-destino'>Ver más</a></p>";
                echo "</div>";
                echo "</div>";
            }

        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error al consultar destinos: {$e->getMessage()}</p>";
        }
        ?>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?> 
