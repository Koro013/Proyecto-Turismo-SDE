<?php 
session_start();
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'es';
$texto = include("lang/$lang.php");

include('includes/header.php');
include('includes/navbar.php');
?>

<main class="container py-4">
    <section class="text-center py-5 hero bg-light rounded shadow-sm">
        <h1 class="display-4 mb-3 bungee-regular">
            <?= $texto['bienvenida'] ?>
        </h1>
        <p class="lead mb-4 bebas-neue-regular">
            <?= $texto['mision'] ?>
        </p>
        <a href="pages/destinos.php" class="btn btn-primary botones-cuerpo">
            <?= $texto['btn_explorar'] ?>
        </a>
    </section>

    <section class="intro text-center mt-5">
        <h2 class="bebas-neue-regular">
            <?= $texto['titulo'] ?>
        </h2>
    </section>
    <div class="text-center mt-3">
        <a href="?lang=es" class="me-2">🇦🇷 Español</a> | <a href="?lang=en" class="ms-2">🇬🇧 English</a>
    </div>
</main>

<?php include('includes/footer.php'); ?>
