<?php
include('includes/header.php');
include('includes/navbar.php');
?>

<!-- BANNER HERO PRINCIPAL -->
<div class="custom-banner-hero d-flex align-items-center mb-5">
    <div class="banner-text col-12 col-lg-6 d-flex align-items-center justify-content-center">
        <h1 class="banner-title mb-0">
            SANTIAGO<br>DEL ESTERO
        </h1>
    </div>
    <div class="banner-img col-12 col-lg-6 p-0 d-flex align-items-stretch">
        <img src="assets/images/las-torres.jpg" class="banner-img-style" alt="Santiago del Estero">
    </div>
</div>

<!-- SECCIÓN DESTINOS -->
<section class="destinos-section mb-5 mx-auto">
  <div class="row justify-content-center">
    <div class="col-auto">
      <div class="cartel-destinos-wrapper">
        <span class="cartel-destinos">DESTINOS</span>
      </div>
    </div>
  </div>

  <div class="destinos-cards d-flex flex-wrap justify-content-center align-items-stretch">
    <a href="pages/destino.php" class="destino-card card text-center">
      <img src="assets/images/estadio-unico.jpg" class="card-img-top" alt="Estadio Único">
      <div class="card-body"><p class="card-title">ESTADIO ÚNICO</p></div>
    </a>
    <a href="pages/destino.php" class="destino-card card text-center">
      <img src="assets/images/estadiode-hockey.jpg" class="card-img-top" alt="Cancha de Hockey">
      <div class="card-body"><p class="card-title">CANCHA DE HOCKEY</p></div>
    </a>
    <a href="pages/destino.php" class="destino-card card text-center">
      <img src="assets/images/las-torres.jpg" class="card-img-top" alt="Complejo Juan Felipe Ibarra">
      <div class="card-body"><p class="card-title">COMPLEJO JUAN FELIPE IBARRA</p></div>
    </a>
    <a href="pages/destino.php" class="destino-card card text-center">
      <img src="assets/images/plaza-libertad.jpg" class="card-img-top" alt="Plaza Libertad">
      <div class="card-body"><p class="card-title">PLAZA LIBERTAD</p></div>
    </a>
  </div>

  <div class="row justify-content-center mt-4">
    <div class="col-auto">
      <a href="pages/destinos.php">
        <button class="btn btn-light ver-mas-btn fw-bold px-5 py-2">VER MÁS</button>
      </a>
    </div>
  </div>
</section>

<!-- BOTONES/SECCIONES GRANDES -->
<div class="botones-secciones my-5">
  <div class="row g-4">
    <div class="col-12">
      <a href="pages/recorridos.php" class="boton-seccion d-flex align-items-center">
        <div class="boton-texto">RECORRIDOS<br>TURÍSTICOS</div>
        <div class="boton-imagen"><img src="assets/images/estadio-unico.jpg" alt="Recorridos"></div>
      </a>
    </div>
    <div class="col-12">
      <a href="pages/planificador.php" class="boton-seccion d-flex align-items-center">
        <div class="boton-texto">PLANIFICADOR</div>
        <div class="boton-imagen"><img src="assets/images/estadiode-hockey.jpg" alt="Planificador"></div>
      </a>
    </div>
    <div class="col-12">
      <a href="https://t.me/TurismoSDE_bot" target="_blank" class="boton-seccion d-flex align-items-center">
        <div class="boton-texto">ASISTENTE<br>DE IA</div>
        <div class="boton-imagen"><img src="assets/images/froilan.png" alt="Asistente IA"></div>
      </a>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>
