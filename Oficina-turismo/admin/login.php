<?php
session_start();
require_once(__DIR__ . '/../config/db.php');

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Consulta a la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :usuario");
    $stmt->execute(['usuario' => $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password_hash'])) {
        $_SESSION['admin'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "❌ Verificación falló para: $usuario / $pass";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            padding-top: 100px;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 350px;
        }
        input {
            display: block;
            margin: 10px 0;
            width: 100%;
            padding: 8px;
            font-size: 1em;
        }
        .btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 1em;
            cursor: pointer;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>🔐 Login Administrador</h2>
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <form method="post" autocomplete="off">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit" class="btn">Ingresar</button>
    </form>
</div>
</body>
</html>

