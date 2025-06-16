<?php
require_once __DIR__ . '/../config/db.php';

// Obtener el ID del destino desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consultar la base de datos
$stmt = $pdo->prepare("SELECT * FROM destinos WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $id]);
$destino = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$destino) {
    echo "<p class='text-center mt-5'>Destino no encontrado.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($destino['nombre']); ?> - Detalles</title>
  <link rel="icon" href="assets/images/favico/favico.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-..." crossorigin="anonymous">

  <!-- Estilo personalizado -->
  <link rel="stylesheet" href="assets/css/front/destino-style.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Montserrat', sans-serif;">

<header>
  <?php include("includes/navbar.php"); ?>
</header>

<main class="container mt-5">
  <div class="card shadow-lg border-0">
    <img src="assets/images/<?php echo htmlspecialchars($destino['imagen']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($destino['nombre']); ?>">

    <div class="card-body">
      <h2 class="card-title text-center mb-3"><?php echo htmlspecialchars($destino['nombre']); ?></h2>
      <p class="card-text text-justify"><?php echo nl2br(htmlspecialchars($destino['descripcion'])); ?></p>
    </div>
  </div>
</main>

<footer class="text-center mt-5 p-3">
  <p>&copy; <?php echo date("Y"); ?> Oficina de Turismo de Santiago del Estero</p>
</footer>

</body>
</html>
