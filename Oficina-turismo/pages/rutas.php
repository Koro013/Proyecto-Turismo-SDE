<?php
session_start();
require_once(__DIR__ . '/../config/db.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recorridos - Turismo - Santiago del Estero</title>
  <link rel="icon" href="../img/favico/favico.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/destino-style.css">
  <link rel="stylesheet" href="../css/destinos-form-styles.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
</head>

<body class="bg-body bebas-neue-regular">

  <!-- NAVBAR -->
  <nav class="navbar bg-dark border-body navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand text-light ms-3" href="#"><img id="navLogo" class="img-fluid"
          src="../img/santiago-logo.png" alt="Logo Turismo" class="img-fluid"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-light pe-5 me-5 fs-3" aria-current="page" href="#">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light pe-5 me-5 fs-3" href="#">Próximos Eventos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light pe-5 me-5 fs-3" href="#">Información</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light pe-5 me-5 fs-3" href="../index.html">Circuito Turistico</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- PRINCIPAL -->
  <main class="container pt-5">

    <section class="form-check-inline me-0">
      <h1 style="font-size: 5em;">Recorridos</h1>
      <!-- Aquí podrías agregar filtros dinámicos por tipo de recorrido si tienes esa funcionalidad -->
    </section>

    <section class="row justify-content-evenly ms-1 me-1">
      <?php
      try {
          $stmt = $pdo->query("SELECT * FROM rutas");
          $hayResultados = false;
          while ($ruta = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $hayResultados = true;
              // Puedes personalizar el ícono según categoría si tienes ese dato
              $icon = "../img/recorrido.svg";
              // O puedes usar distintos íconos si tu tabla de rutas tiene una columna para ello
              echo '<a href="/Oficina-turismo/pages/detalle_ruta.php?id=' . $ruta['IdRecorrido'] . '" class="card btn btn-light col-lg-3 p-0 me-lg-3 mb-lg-3 mb-3 col-md-12 tarjeta-recorrido">';
              echo '  <img src="' . $icon . '" class="card-img-top p-5 tarjeta-imagen" alt="...">';
              echo '  <div class="card-body">';
              echo '    <p class="card-text fs-2">' . htmlspecialchars($ruta['Nombre']) . '</p>';
              echo '    <div class="roboto-300">';
              echo '      <p class="card-text text-start fs-5"><strong>Duración:</strong> ' . htmlspecialchars($ruta['Duracion']) . ' min</p>';
              echo '      <p class="card-text text-start fs-5"><strong>Costo:</strong> $' . number_format($ruta['CostoDelRecorrido'], 2) . '</p>';
              echo '      <p class="card-text text-start fs-5"><strong>Edad Recomendada:</strong> ' . htmlspecialchars($ruta['EdadRecomendada']) . '+</p>';
              echo '      <p class="card-text text-start fs-5">' . htmlspecialchars($ruta['Descripcion']) . '</p>';
              echo '    </div>';
              echo '  </div>';
              echo '</a>';
          }
          if (!$hayResultados) {
              echo "<div class='alert alert-info fs-4 mt-4'>No se encontraron recorridos registrados.</div>";
          }
      } catch (PDOException $e) {
          echo "<div class='alert alert-danger'>Error al consultar rutas: {$e->getMessage()}</div>";
      }
      ?>
    </section>
  </main>

  <!-- PIE DE PAGINA -->
  <footer class="container-fluid separacion-texto mt-4">
    <div class="row align-items-start nav-color pt-4">
      <div
        class="col-lg-5 col-md-12 card-footer text-light pt-sm-5 pb-sm-5 ps-3 pe-sm-5 pt-lg-5 pb-lg-5 ps-lg-5 pe-lg-5 text-light">
        <h1 class="mb-5"><strong>Contacto</strong></h1>
        <h4 class="mb-3"><strong>Direccion:</strong> Av. Libertad 417, Santiago del Estero</h4>
        <h4 class="mb-3"><strong>Código Postal:</strong> G4200</h4>
        <h4 class="mb-3"><strong>Teléfono:</strong> +54 385 421-4243</h4>
        <h4 class="mb-3"><strong>WhatsApp:</strong> +54 385 475-7749</h4>
        <h4 class="mb-3"><strong>Correo:</strong> <a href="mailto:santiagoturismo2021@gmail.com"
            style="text-decoration: none; color: aliceblue;">santiagoturismo2021@gmail.com</a></h4>
      </div>
      <div class="flex-column text-center pt-3 pb-3 px-3 col-lg-7 col-md-12 card-footer text-light text-light">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3529.743254793991!2d-64.26247042469637!3d-27.78688407613697!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x943b52115ea3ac05%3A0xb108231a9dab0636!2sSub%20Secretar%C3%ADa%20de%20Turismo%20de%20la%20Provincia%20de%20Santiago%20del%20Estero!5e0!3m2!1ses-419!2sar!4v1747236619964!5m2!1ses-419!2sar"
          class="mapa w-75" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
    <div class="row align-items-end">
      <div class="col card-footer text-center text-light bg-dark p-4">
        &copy; Turismo - Santiago del Estero
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
