<?php
require 'db.php';
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
$totalsOverride = [
    'duracion' => $_POST['total_duracion'] ?? null,
    'costo' => $_POST['total_costo'] ?? null,
];

foreach ($totalsOverride as $key => $value) {
    if (!is_numeric($value)) {
        unset($totalsOverride[$key]);
    } else {
        $totalsOverride[$key] += 0;
    }
}

$content = plan_pdf_build_content($destinos, $totalsOverride);
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
