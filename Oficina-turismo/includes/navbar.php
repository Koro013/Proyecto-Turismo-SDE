<?php

$current = basename($_SERVER['PHP_SELF']);
?>

<nav class="sde-navbar">
    <div class="sde-logo">
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/98/Escudo_de_la_Provincia_de_Santiago_del_Estero.svg" alt="Logo Santiago" />
        <span>Turismo SDE</span>
    </div>
    <ul class="sde-nav-links">
        <li class="<?= $current == 'index.php' ? 'active' : '' ?>"><a href="/index.php">Inicio</a></li>
        <li class="<?= $current == 'destinos.php' ? 'active' : '' ?>"><a href="/destinos.php">Destinos</a></li>
        <li class="<?= $current == 'rutas.php' ? 'active' : '' ?>"><a href="/rutas.php">Rutas</a></li>
        <li class="<?= $current == 'planificador.php' ? 'active' : '' ?>"><a href="/planificador.php">Planificador</a></li>
        <li class="<?= $current == 'suscripcion.php' ? 'active' : '' ?>"><a href="/suscripcion.php">Suscripción</a></li>
        <li class="<?= $current == 'contacto.php' ? 'active' : '' ?>"><a href="/contacto.php">Contacto</a></li>
    </ul>
</nav>
