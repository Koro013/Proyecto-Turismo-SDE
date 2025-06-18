<?php

$current = basename($_SERVER['PHP_SELF']);
?>

<nav class="sde-navbar">
    <div class="sde-logo">
  <img src="/OFICINA-TURISMO/assets/images/logo_santiago.png" alt="Logo Turismo SDE" style="height:40px; margin-right:10px;">
  <span>Turismo SDE</span>
</div>

    <ul class="sde-nav-links">
        <li class="<?= $current == 'index.php' ? 'active' : '' ?>"><a href="/Oficina-turismo/index.php">Inicio</a></li>
        <li class="<?= $current == 'destinos.php' ? 'active' : '' ?>"><a href="/Oficina-turismo/pages/destinos.php">Destinos</a></li>
        <li class="<?= $current == 'rutas.php' ? 'active' : '' ?>"><a href="/Oficina-turismo/pages/rutas.php">Rutas</a></li>
        <li class="<?= $current == 'planificador.php' ? 'active' : '' ?>"><a href="/Oficina-turismo/pages/planificador.php">Planificador</a></li>
        <li class="<?= $current == 'suscripcion.php' ? 'active' : '' ?>"><a href="/Oficina-turismo/pages/suscripcion.php">Suscripción</a></li>
        <li class="<?= $current == 'contacto.php' ? 'active' : '' ?>"><a href="/Oficina-turismo/pages/contacto.php">Contacto</a></li>
    </ul>
</nav>
