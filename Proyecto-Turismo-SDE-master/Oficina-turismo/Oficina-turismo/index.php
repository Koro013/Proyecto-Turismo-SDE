<?php
// Conexión a la base de datos
require_once __DIR__ . '/config/db.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recorridos Turísticos - Turismo - Santiago del Estero</title>
  <link rel="icon" href="assets/images/favico/favico.png" type="image/x-icon">

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="assets/css/front/index-style.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
</head>

<body class="bg-body bebas-neue-regular">

  <header>
    <?php include("includes/navbar.php"); ?>
  </header>

  <main class="container mt-5">
    <h1 class="text-center mb-4">Bienvenido a los Recorridos Turísticos</h1>

    <div class="row">
    <?php
      $stmt = $pdo->query("SELECT * FROM destinos ORDER BY nombre ASC");
      $destinos = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($destinos):
        foreach ($destinos as $destino):
    ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="assets/images/<?php echo htmlspecialchars($destino['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($destino['nombre']); ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($destino['nombre']); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars($destino['descripcion']); ?></p>
            </div>
          </div>
        </div>
    <?php
        endforeach;
      else:
    ?>
        <p class="text-center">No hay destinos disponibles en este momento.</p>
    <?php endif; ?>
    </div>
  </main>

  <footer class="text-center mt-5 p-3">
    <p>&copy; <?php echo date("Y"); ?> Oficina de Turismo de Santiago del Estero</p>
  </footer>

</body>
</html>
