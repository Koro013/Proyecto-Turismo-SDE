<?php 
include('../includes/header.php');
include('../includes/navbar.php');
?>

<main>
    <h2>Contacto</h2>
    <form action="#" method="post" class="form">
        <input type="text" name="nombre" placeholder="Tu nombre" required>
        <input type="email" name="email" placeholder="Tu correo" required>
        <textarea name="mensaje" placeholder="Tu mensaje" rows="5" required></textarea>
        <button type="submit">Enviar</button>
    </form>

    <p>📍 Oficina de Turismo - Santiago del Estero</p>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="300" style="border:0;" allowfullscreen=""></iframe>
</main>

<?php include('../includes/footer.php'); ?>
