<?php
$host = 'localhost';
$db   = 'oficinaturismorecorridos'; // nombre exacto de tu base de datos
$user = 'root';                     // usuario por defecto en XAMPP
$pass = '';                         // contraseña vacía por defecto

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión a la base de datos: " . $e->getMessage());
}
?>
