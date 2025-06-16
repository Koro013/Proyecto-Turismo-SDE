<?php
require_once __DIR__ . '/../config/db.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Recorridos Turísticos - Turismo SDE</title>
  <link rel="icon" href="assets/images/favico/favico.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-..." crossorigin="anonymous">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="assets/css/front/recorridos-style.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Montserrat', sans-serif;">

<header>
  <?php include("includes/navbar.php"); ?>
</header>

<main class="container mt-5">
  <h1 class="text-center mb-4">Recorridos Turísticos</h1>

  <div class="row">
    <?php
      $stmt = $pdo->query("SELECT * FROM rutas ORDER BY nombre ASC");
      $rutas = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($rutas):
        foreach ($rutas as $ruta):
    ?>
      <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body">
            <h4 class="card-title"><?php echo htmlspecialchars($ruta['nombre']); ?></h4>
            <p class="card-text"><?php echo htmlspecialchars($ruta['descripcion']); ?></p>
          </div>
          <div class="card-footer bg-white text-end">
            <a href="detalle_ruta.php?id=<?php echo $ruta['id']; ?>" class="btn btn-outline-primary">Ver Recorrido</a>
          </div>
        </div>
      </div>
    <?php
        endforeach;
      else:
    ?>
      <p class="text-center">No hay rutas disponibles actualmente.</p>
    <?php endif; ?>
  </div>
</main>

<footer class="text-center mt-5 p-3 bg-light">
  <p>&copy; <?php echo date("Y"); ?> Oficina de Turismo de Santiago del Estero</p>
</footer>

</body>
</html>
