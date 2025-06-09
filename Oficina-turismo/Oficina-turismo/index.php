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

<main>
    <section class="hero">
        <h1><?= $texto['bienvenida'] ?></h1>
        <p><?= $texto['mision'] ?></p>
        <a href="pages/destinos.php" class="btn"><?= $texto['btn_explorar'] ?></a>
    </section>

    <section class="intro">
        <h2><?= $texto['titulo'] ?></h2>
    </section>
    <a href="?lang=es">🇦🇷 Español</a> | <a href="?lang=en">🇬🇧 English</a>
</main>

<?php include('includes/footer.php'); ?>
