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

<!-- Estilos específicos de la página -->
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/front/destinos-style.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/front/destinos-form-styles.css">

<main class="container pb-3 separacion-texto">
    <div class="container cartel text-light my-5 text-center">Destinos</div>

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

    <section class="row justify-content-start ms-1 me-1">
        <?php
        try {
            if ($categoriaSeleccionada) {
                $stmt = $pdo->prepare("SELECT d.*, c.Descripcion AS CategoriaNombre FROM destinos d INNER JOIN categorias c ON d.IdCategoria = c.IdCategoria WHERE d.IdCategoria = :id");
                $stmt->execute(['id' => $categoriaSeleccionada]);
            } else {
                $stmt = $pdo->query("SELECT d.*, c.Descripcion AS CategoriaNombre FROM destinos d INNER JOIN categorias c ON d.IdCategoria = c.IdCategoria");
            }

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <a href="<?= BASE_URL ?>/pages/detalle_destino.php?id=<?= $row['IdLugar'] ?>" class="card btn btn-light col-lg-3 p-0 me-lg-3 mb-lg-3 mb-3 col-md-12 tarjeta-destinos">
                    <img src="<?= BASE_URL ?>/assets/images/<?= $row['ImagenDelLugar'] ?>" class="card-img-top tarjeta-imagen" alt="<?= $row['Nombre'] ?>">
                    <div class="card-body">
                        <p class="card-text fs-3"><?= $row['Nombre'] ?></p>
                    </div>
                </a>
                <?php
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error al consultar destinos: {$e->getMessage()}</p>";
        }
        ?>
    </section>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
