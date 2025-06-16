<?php 
session_start();
require_once(__DIR__ . '/../config/db.php');
$pageStyles = ['/Oficina-turismo/assets/css/front/recorridos-style.css'];
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<main class="container py-4">
    <h2 class="mb-4 text-center">Rutas Sugeridas</h2>
    <div class="grid row row-cols-1 row-cols-md-3 g-4">
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM rutas");
            while ($ruta = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='col'>";
                echo "  <div class='card tarjeta-recorrido h-100 text-center shadow-sm'>";
                echo "    <div class='card-body'>";
                echo "      <h3 class='card-title h5 bebas-neue-regular mb-2'>{$ruta['Nombre']}</h3>";
                echo "      <p class='card-text'><strong>Duración:</strong> {$ruta['Duracion']} min</p>";
                echo "      <p class='card-text'><strong>Costo:</strong> \$" . number_format($ruta['CostoDelRecorrido'], 2) . "</p>";
                echo "      <p class='card-text'><strong>Edad Recomendada:</strong> {$ruta['EdadRecomendada']}+</p>";
                echo "      <p class='card-text'>{$ruta['Descripcion']}</p>";
                echo "      <a href='/Oficina-turismo/pages/detalle_ruta.php?id={$ruta['IdRecorrido']}' class='btn btn-primary botones-cuerpo'>Ver más</a>";
                echo "    </div>";
                echo "  </div>";
                echo "</div>";
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error al consultar rutas: {$e->getMessage()}</p>";
        }
        ?>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
