<?php
require 'db.php';
require_once __DIR__ . '/lib/PlanPdfFormatter.php';

$dompdfAvailable = false;
$dompdfClass = 'Dompdf\\Dompdf';
$vendorAutoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($vendorAutoload)) {
    require_once $vendorAutoload;
    if (class_exists($dompdfClass)) {
        $dompdfAvailable = true;
    }
}
if (!$dompdfAvailable) {
    require_once __DIR__ . '/lib/SimplePdf.php';
}

$ids = $_POST['destinos'] ?? [];
if (empty($ids)) {
    die('No se seleccionaron destinos');
}
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT nombre, duracion, costo FROM destinos WHERE id IN ($placeholders)");
$stmt->execute($ids);
$destinos = $stmt->fetchAll();
$content = plan_pdf_build_content($destinos);
$html = $content['html'];
$lines = $content['lines'];

if ($dompdfAvailable) {
    $dompdf = new $dompdfClass();
    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream('plan.pdf', ['Attachment' => false]);
    exit;
}

simple_pdf_output('Plan de Viaje', $lines, 'plan.pdf');
exit;
?>
