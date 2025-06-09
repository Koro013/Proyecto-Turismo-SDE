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

<main>
    <h2>Suscribite a nuestro boletín</h2>
    <form action="" method="post" class="form">
        <input type="email" name="email" placeholder="Tu correo electrónico" required>
        <button type="submit">Suscribirme</button>
    </form>
</main>

<?php include('../includes/footer.php'); ?>
