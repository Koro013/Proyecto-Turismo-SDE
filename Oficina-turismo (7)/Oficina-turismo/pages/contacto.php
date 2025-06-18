<?php 
include('../includes/header.php');
include('../includes/navbar.php');
?>

<main class="sde-contacto-container py-4">
    <h2 class="sde-contacto-titulo text-center mb-4">Contacto</h2>
    <form action="#" method="post" class="sde-form-contacto mb-4">
        <div class="mb-3">
            <input type="text" name="nombre" class="sde-input" placeholder="Tu nombre" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="sde-input" placeholder="Tu correo" required>
        </div>
        <div class="mb-3">
            <textarea name="mensaje" class="sde-input sde-textarea" placeholder="Tu mensaje" rows="5" required></textarea>
        </div>
        <button type="submit" class="sde-btn-enviar">Enviar</button>
    </form>

    <p class="sde-contacto-oficina text-center mb-3">📍 Oficina de Turismo - Santiago del Estero</p>
    <div class="sde-contacto-mapa">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="300" style="border:0;" allowfullscreen=""></iframe>
    </div>
</main>

<?php include('../includes/footer.php'); ?>  
