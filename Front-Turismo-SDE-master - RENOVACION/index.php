<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recorridos Turisticos - Turismo - Santiago del Estero</title>
  <?php include_once('layout\links_head.html'); ?>

</head>

<body class="bg-body bebas-neue-regular">

  <header>
    <!-- Barra de Navegación -->
    <?php include_once("./layout/nav_bar.html"); ?>

    <!-- Banner Principal -->
    <div class="container-fluid px-0 nav-color mb-5 mt-5 pt-4">
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
                <img src="./img/estadio-unico.jpg" class="d-block w-100 h-100 p-img-carrousel" alt="Estadio-Unico">
              </div>
              <div class="carousel-item conteiner-img-carrousel" data-bs-interval="5000">
                <img src="./img/estadiode-hockey.jpg" class="d-block w-100 h-100 p-img-carrousel"
                  alt="Estadio-de-Hokey">
              </div>
              <div class="carousel-item conteiner-img-carrousel" data-bs-interval="5000">
                <img src="./img/las-torres.jpg" class="d-block w-100 h-100 p-img-carrousel"
                  alt="Complejo-Juan-Felipe-Ibarra">
              </div>
              <div class="carousel-item conteiner-img-carrousel" data-bs-interval="5000">
                <img src="./img/puente-carretero.jpg" class="d-block w-100 h-100 p-img-carrousel"
                  alt="Puente-Carretero">
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>


  </header>

  <!-- PRINCIPAL -->
  <main class="container-fluid pb-3 separacion-texto">

    <div class="container cartel text-light my-5 text-center ">
      Destinos
    </div>

    <section class="mb-5 text-center">
      <div class="card mi-tajeta nav-color">

        <div class="row card-body bg-transparent justify-content-center px-5 px-lg-0 px-sm-5 py-4">

          <a href="destino.php"
            class="card btn btn-light p-0 me-lg-3 mb-lg-0 mb-3 col-lg-3 tarjeta-inicio">
            <img src="./img/estadio-unico.jpg" class="card-img-top tarjeta-imagen" alt="Estadio-Unico">
            <div class="card-body">
              <p class="card-text fs-3">Estadio Único</p>
            </div>
          </a>

          <a href="destino.php"
            class="card btn btn-light p-0 me-lg-3 mb-lg-0 mb-3 col-lg-3 tarjeta-inicio">
            <img src="./img/estadiode-hockey.jpg" class="card-img-top tarjeta-imagen" alt="Estadio-Unico">
            <div class="card-body">
              <p class="card-text fs-3">Cancha de Hockey</p>
            </div>
          </a>

          <a href="destino.php"
            class="card btn btn-light p-0 me-lg-3 mb-lg-0 mb-3 col-lg-3 tarjeta-inicio">
            <img src="./img/las-torres.jpg" class="card-img-top tarjeta-imagen" alt="Estadio-Unico">
            <div class="card-body">
              <p class="card-text fs-3">Complejo Juan Felipe Ibarra</p>
            </div>
          </a>

          <a href="destino.php"
            class="card btn btn-light p-0 me-lg-3 mb-lg-0 mb-3 col-lg-3 tarjeta-inicio">
            <img src="./img/plaza-libertad.jpg" class="card-img-top tarjeta-imagen" alt="Estadio-Unico">
            <div class="card-body">
              <p class="card-text fs-3">Plaza Libertad</p>
            </div>
      

          <div style="width: 24rem;">
            <a href="destinos.php">
              <button type="button" class="btn btn-light fs-3 mt-lg-5 mt-3 col-md-12 separacion-texto">Ver Más</button>
            </a>
          </div>

        </div>
      </div>
    </section>


    <a href="recorridos.php">
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
                <img src="./img/estadio-unico.jpg"
                  class="d-block w-100 h-100 p-img-carrousel border-tarjeta botones-cuerpo" alt="Estadio-Unico">
              </div>

            </div>

          </div>
        </div>
      </section>
    </a>

    <a href="planificador.php">
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
                <img src="./img/estadiode-hockey.jpg"
                  class="d-block w-100 h-100 p-img-carrousel border-tarjeta botones-cuerpo" alt="Estadio-Unico">
              </div>

            </div>

          </div>
        </div>
      </section>
    </a>

    <a href="">
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
                <img src="./img/froilan.png" class="d-block w-100 h-100 p-img-carrousel border-tarjeta botones-cuerpo"
                  alt="Patio del Indio Froilan">
              </div>

            </div>

          </div>
        </div>
      </section>
    </a>

  </main>

  <!-- PIE DE PAGINA -->
  
  <?php include_once('./layout/footer.html'); ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>