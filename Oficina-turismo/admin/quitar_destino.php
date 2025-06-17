<?php
session_start();
include('../config/db.php');
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM destinos WHERE id = ?");
$stmt->execute([$id]);

header("Location: dashboard.php");
exit();
