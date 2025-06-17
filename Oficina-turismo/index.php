<?php 
session_start();
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'es';
$texto = include("lang/$lang.php");

include('includes/header.php'); // Incluye <head> y <body>
include('includes/navbar.php'); // Navbar ya modernizada
?>

<!-- Banner con imagen representativa de Santiago del Estero -->
<section class="sde-banner">
    <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1350&q=80" alt="Paisaje Santiago del Estero">
    <div class="sde-banner-text">
        <h1>Descubrí Santiago del Estero</h1>
        <p>Cultura, historia y naturaleza en el corazón del norte argentino</p>
    </div>
</section>

<main class="sde-container">
    <!-- Hero de bienvenida -->
    <section class="sde-hero">
        <h1><?= $texto['bienvenida'] ?></h1>
        <p><?= $texto['mision'] ?></p>
        <a href="destinos.php" class="sde-btn-principal"><?= $texto['btn_explorar'] ?></a>
    </section>

    <!-- Intro -->
    <section class="sde-intro">
        <h2><?= $texto['titulo'] ?></h2>
    </section>

    <!-- Selector de idioma -->
    <div class="sde-languages">
        <a href="?lang=es" class="sde-lang">🇦🇷 Español</a> | <a href="?lang=en" class="sde-lang">🇬🇧 English</a>
    </div>

    <!-- Lugares destacados con imágenes fijas -->
    <section class="sde-destacados">
        <h2>Lugares destacados</h2>
        <div class="sde-destinos-grid">
            <div class="sde-destino-card">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=500&q=80" alt="Termas de Río Hondo">
                <h3>Termas de Río Hondo</h3>
                <p>Famosas aguas termales y gran centro turístico de relax y bienestar.</p>
            </div>
            <div class="sde-destino-card">
                <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=500&q=80" alt="Parque Nacional Copo">
                <h3>Parque Nacional Copo</h3>
                <p>Naturaleza y biodiversidad autóctona del Gran Chaco.</p>
            </div>
            <div class="sde-destino-card">
                <img src="https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=500&q=80" alt="Ciudad Capital">
                <h3>Ciudad Capital</h3>
                <p>Cultura, historia y la cuna del folclore santiagueño.</p>
            </div>
            <!-- Agrega más destinos aquí según tus datos -->
        </div>
    </section>
</main>

<?php include('includes/footer.php'); // Footer moderno ?>

