<?php 
include('../includes/header.php');
include('../includes/navbar.php');
?>

<main class="container py-4" style="max-width: 800px;">
    <h2 class="text-center mb-4">Contacto</h2>
    <form action="#" method="post" class="form mb-4">
        <div class="mb-3">
            <input type="text" name="nombre" class="form-control" placeholder="Tu nombre" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Tu correo" required>
        </div>
        <div class="mb-3">
            <textarea name="mensaje" class="form-control" placeholder="Tu mensaje" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    <p class="text-center">📍 Oficina de Turismo - Santiago del Estero</p>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="300" style="border:0;" allowfullscreen=""></iframe>
</main>

<?php include('../includes/footer.php'); ?>
