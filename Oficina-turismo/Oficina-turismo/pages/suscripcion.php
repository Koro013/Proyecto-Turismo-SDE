<?php 
include('../config/db.php');
include('../includes/header.php');
include('../includes/navbar.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $pdo->prepare("INSERT INTO suscriptores (email) VALUES (:email)");
    $stmt->execute(['email' => $email]);
    echo "<p>Gracias por suscribirte al boletín informativo.</p>";
}
?>

<main class="container py-4" style="max-width: 600px;">
    <h2 class="text-center mb-4">Suscribite a nuestro boletín</h2>
    <form action="" method="post" class="form">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Tu correo electrónico" required>
        </div>
        <button type="submit" class="btn btn-primary">Suscribirme</button>
    </form>
</main>

<?php include('../includes/footer.php'); ?>
