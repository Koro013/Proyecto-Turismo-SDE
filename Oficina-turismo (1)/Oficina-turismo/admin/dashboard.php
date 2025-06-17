<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('../config/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        a { margin-right: 10px; }
    </style>
</head>
<body>
    <h2>Panel de Administración</h2>
    <p>Bienvenido, <?php echo $_SESSION['admin']; ?>!</p>
    <ul>
        <li><a href="agregar_destino.php">Agregar Destino</a></li>
        <li><a href="logout.php">Cerrar Sesión</a></li>
    </ul>

    <h3>Destinos Cargados:</h3>
    <?php
    $stmt = $pdo->query("SELECT * FROM destinos");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p>
                <strong>{$row['nombre']}</strong><br>
                <a href='editar_destino.php?id={$row['id']}'>📝 Editar</a>
                <a href='eliminar_destino.php?id={$row['id']}' onclick='return confirm(\"¿Eliminar destino?\")'>🗑️ Eliminar</a>
              </p><hr>";
    }
    ?>
</body>
</html>
