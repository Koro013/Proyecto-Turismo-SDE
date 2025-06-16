<?php 
session_start();
require_once(__DIR__ . '/../config/db.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<!-- Estilos específicos de la página -->
<link rel="stylesheet" href="/Oficina-turismo/assets/css/front/recorridos-style.css">
<link rel="stylesheet" href="/Oficina-turismo/assets/css/front/recorridos-form-styles.css">

<main class="container py-4">
    <h2 class="mb-4 text-center">Rutas Sugeridas</h2>
    <div class="grid row row-cols-1 row-cols-md-3 g-4">
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM rutas");
            while ($ruta = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='card'>";
                echo "<h3>{$ruta['Nombre']}</h3>";
                echo "<p><strong>Duración:</strong> {$ruta['Duracion']} min</p>";
                echo "<p><strong>Costo:</strong> \$" . number_format($ruta['CostoDelRecorrido'], 2) . "</p>";
                echo "<p><strong>Edad Recomendada:</strong> {$ruta['EdadRecomendada']}+</p>";
                echo "<p>{$ruta['Descripcion']}</p>";

                // 🔗 Enlace al detalle de la ruta
                echo "<p><a href='/Oficina-turismo/pages/detalle_ruta.php?id={$ruta['IdRecorrido']}' class='btn'>Ver más</a></p>";

                echo "</div>";
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error al consultar rutas: {$e->getMessage()}</p>";
        }
        ?>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
