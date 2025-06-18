<?php 
session_start();
require_once(__DIR__ . '/../config/db.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<main class="sde-rutas-container py-4">
    <h2 class="sde-rutas-titulo mb-4 text-center">Rutas Sugeridas</h2>
    <div class="sde-rutas-grid">
        <?php
        // Función para elegir imagen libre según nombre de la ruta (puedes personalizar según tu base)
        function imagenLibrePorRuta($nombre) {
            $imagenes = [
                'Ruta Histórica' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=500&q=80',
                'Ruta Natural' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=500&q=80',
                'Ruta Religiosa' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=500&q=80',
                // Agrega más según tus rutas
            ];
            return $imagenes[$nombre] ?? 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=500&q=80';
        }

        try {
            $stmt = $pdo->query("SELECT * FROM rutas");
            while ($ruta = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $imgRuta = imagenLibrePorRuta($ruta['Nombre']);
                echo "<div class='sde-ruta-card'>";
                echo "<img src='{$imgRuta}' alt='{$ruta['Nombre']}'>";
                echo "<div class='sde-ruta-card-content'>";
                echo "<h3>{$ruta['Nombre']}</h3>";
                echo "<p><strong>Duración:</strong> {$ruta['Duracion']} min</p>";
                echo "<p><strong>Costo:</strong> \$" . number_format($ruta['CostoDelRecorrido'], 2) . "</p>";
                echo "<p><strong>Edad Recomendada:</strong> {$ruta['EdadRecomendada']}+</p>";
                echo "<p>{$ruta['Descripcion']}</p>";
                // Enlace al detalle de la ruta
                echo "<p><a href='/Oficina-turismo/pages/detalle_ruta.php?id={$ruta['IdRecorrido']}' class='sde-btn-ruta'>Ver más</a></p>";
                echo "</div>";
                echo "</div>";
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error al consultar rutas: {$e->getMessage()}</p>";
        }
        ?>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?> 
