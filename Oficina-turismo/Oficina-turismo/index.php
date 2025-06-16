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

<div class="container-fluid px-0 nav-color mb-5">
    <div class="row mx-0">
        <div class="col-6 position-relative bungee-regular d-flex text-center">
            <div id="bannerTexto" class="position-absolute ps-3 top-50 start-50 translate-middle">
                Recorridos Turísticos
            </div>
        </div>
        <div class="col-6 ps-4 px-0">
            <div id="carouselTurismoSantiago" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner border-carrousel img-carrousel">
                    <div class="solapados carousel-item active conteiner-img-carrousel" data-bs-interval="5000">
                        <img src="<?= BASE_URL ?>/assets/images/estadio-unico.jpg" class="d-block w-100 h-100 p-img-carrousel" alt="Estadio-Unico">
                    </div>
                    <div class="carousel-item conteiner-img-carrousel" data-bs-interval="5000">
                        <img src="<?= BASE_URL ?>/assets/images/estadiode-hockey.jpg" class="d-block w-100 h-100 p-img-carrousel" alt="Estadio-de-Hokey">
                    </div>
                    <div class="carousel-item conteiner-img-carrousel" data-bs-interval="5000">
                        <img src="<?= BASE_URL ?>/assets/images/las-torres.jpg" class="d-block w-100 h-100 p-img-carrousel" alt="Complejo-Juan-Felipe-Ibarra">
                    </div>
                    <div class="carousel-item conteiner-img-carrousel" data-bs-interval="5000">
                        <img src="<?= BASE_URL ?>/assets/images/puente-carretero.jpg" class="d-block w-100 h-100 p-img-carrousel" alt="Puente-Carretero">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="container pb-3 separacion-texto">
    <div class="container cartel text-light my-5 text-center">
        Destinos
    </div>

    <section class="mb-5 text-center">
        <div class="card mi-tajeta nav-color">
            <div class="row card-body bg-transparent justify-content-center px-4 py-4">
                <a href="pages/detalle_destino.php?id=1" class="card btn btn-light col-3 p-0 me-lg-3 mb-lg-0 mb-3 col-md-12 tarjeta-inicio">
                    <img src="<?= BASE_URL ?>/assets/images/estadio-unico.jpg" class="card-img-top tarjeta-imagen" alt="Estadio Único">
                    <div class="card-body">
                        <p class="card-text fs-3">Estadio Único</p>
                    </div>
                </a>
                <div class="card btn btn-light col-3 p-0 me-lg-3 mb-lg-0 mb-3 col-md-12 tarjeta-inicio">
                    <img src="<?= BASE_URL ?>/assets/images/estadiode-hockey.jpg" class="card-img-top tarjeta-imagen" alt="Cancha de Hockey">
                    <div class="card-body">
                        <p class="card-text fs-3">Cancha de Hockey</p>
                    </div>
                </div>
                <div class="card btn btn-light col-3 p-0 me-lg-3 mb-lg-0 mb-3 col-md-12 tarjeta-inicio">
                    <img src="<?= BASE_URL ?>/assets/images/las-torres.jpg" class="card-img-top mw-100 tarjeta-imagen" alt="Complejo Juan Felipe Ibarra">
                    <div class="card-body">
                        <p class="card-text fs-3">Complejo Juan Felipe Ibarra</p>
                    </div>
                </div>
                <div class="card btn btn-light col-3 p-0 mb-lg-0 mb-3 col-md-12 tarjeta-inicio">
                    <img src="<?= BASE_URL ?>/assets/images/plaza-libertad.jpg" class="card-img-top tarjeta-imagen" alt="Plaza Libertad">
                    <div class="card-body">
                        <p class="card-text fs-3">Plaza Libertad</p>
                    </div>
                </div>
                <div style="width: 24rem;">
                    <a href="pages/destinos.php">
                        <button type="button" class="btn btn-light fs-3 mt-lg-5 mt-3 col-md-12 separacion-texto">Ver Más</button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <a href="pages/rutas.php">
        <section class="mb-5">
            <div class="card bg-dark-subtle text-light p-0" style="border: 0px; border-radius: 12px;">
                <div class="card-body tarjeta-centro p-0">
                    <div class="row mx-0">
                        <div class="col position-relative d-flex text-center">
                            <div class="position-absolute top-50 start-50 translate-middle">
                                Recorridos Turísticos
                            </div>
                        </div>
                        <div class="col-5 px-0">
                            <img src="<?= BASE_URL ?>/assets/images/estadio-unico.jpg" class="d-block w-100 h-100 p-img-carrousel border-tarjeta botones-cuerpo" alt="Estadio-Unico">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </a>

    <a href="pages/planificador.php">
        <section class="mb-5">
            <div class="card bg-dark-subtle text-light p-0" style="border: 0px; border-radius: 12px;">
                <div class="card-body tarjeta-centro p-0">
                    <div class="row mx-0">
                        <div class="col position-relative d-flex text-center">
                            <div class="position-absolute top-50 start-50 translate-middle">
                                Planificador
                            </div>
                        </div>
                        <div class="col-5 px-0">
                            <img src="<?= BASE_URL ?>/assets/images/estadiode-hockey.jpg" class="d-block w-100 h-100 p-img-carrousel border-tarjeta botones-cuerpo" alt="Estadio-Unico">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </a>

    <section class="mb-5">
        <div class="card bg-dark-subtle text-light p-0" style="border: 0px; border-radius: 12px">
            <div class="card-body tarjeta-centro p-0">
                <div class="row mx-0">
                    <div class="col position-relative d-flex text-center">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            Asistente de IA
                        </div>
                    </div>
                    <div class="col-5 px-0">
                        <img src="<?= BASE_URL ?>/assets/images/froilan.png" class="d-block w-100 h-100 p-img-carrousel border-tarjeta botones-cuerpo" alt="Patio del Indio Froilan">
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>
