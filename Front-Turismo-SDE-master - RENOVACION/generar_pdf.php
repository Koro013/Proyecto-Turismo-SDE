<?php
require 'db.php';
require_once __DIR__ . '/vendor/autoload.php';
use Dompdf\Dompdf;

$ids = $_POST['destinos'] ?? [];
if (empty($ids)) {
    die('No se seleccionaron destinos');
}
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT nombre, duracion, costo FROM destinos WHERE id IN ($placeholders)");
$stmt->execute($ids);
$destinos = $stmt->fetchAll();
$totalDur = array_sum(array_column($destinos, 'duracion'));
$totalCosto = array_sum(array_column($destinos, 'costo'));

$html = '<h1>Plan de Viaje</h1><ul>';
foreach ($destinos as $d) {
    $html .= '<li>'.htmlspecialchars($d['nombre']).' - '.(int)$d['duracion'].' min - $'.number_format($d['costo'],2).'</li>';
}
$html .= '</ul>';
$html .= '<p>Total tiempo: '.(int)$totalDur.' min</p>';
$html .= '<p>Total costo: $'.number_format($totalCosto,2).'</p>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream('plan.pdf', ['Attachment' => false]);
exit;
?>
