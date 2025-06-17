<?php 
include('../config/db.php');
include('../includes/header.php');
include('../includes/navbar.php');

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $pdo->prepare("INSERT INTO suscriptores (email) VALUES (:email)");
    $stmt->execute(['email' => $email]);
    $mensaje = "<div class='sde-alert-success'>¡Gracias por suscribirte al boletín informativo! 😊</div>";
}
?>

<main class="sde-suscripcion-container py-4">
    <h2 class="sde-suscripcion-titulo text-center mb-4">Suscribite a nuestro boletín</h2>
    <?= $mensaje ?>
    <form action="" method="post" class="sde-form-suscripcion">
        <div class="mb-3">
            <input type="email" name="email" class="sde-input" placeholder="Tu correo electrónico" required>
        </div>
        <button type="submit" class="sde-btn-suscribir">Suscribirme</button>
    </form>
</main>

<?php include('../includes/footer.php'); ?>  
