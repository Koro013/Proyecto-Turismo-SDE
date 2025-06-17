<?php
require_once('fpdf.php');

if (!isset($_POST['lugares']) || empty($_POST['lugares'])) {
    echo "⚠️ No se recibió información para generar el PDF.";
    exit;
}

$data = json_decode($_POST['lugares'], true);

$pdf = new FPDF();
$pdf->AddPage();

// Logo (ajustá el path si lo movés)
$pdf->Image('../assets/images/logo_santiago.png', 10, 6, 50);
$pdf->Ln(20);

// Título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode(' Mi Ruta Personalizada'), 0, 1, 'C');
$pdf->Ln(5);

// Duración y costo
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode("Duración total: {$data['duracion_total']} minutos"), 0, 1);
$pdf->Cell(0, 10, utf8_decode("Costo total: $" . number_format($data['costo_total'], 2)), 0, 1);
$pdf->Ln(5);

// Tabla de lugares
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(85, 10, utf8_decode('Nombre'), 1);
$pdf->Cell(30, 10, 'Latitud', 1);
$pdf->Cell(30, 10, 'Longitud', 1);
$pdf->Cell(40, 10, 'Costo', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
foreach ($data['lugares'] as $lugar) {
    $pdf->Cell(85, 10, utf8_decode($lugar['nombre']), 1);
    $pdf->Cell(30, 10, $lugar['lat'], 1);
    $pdf->Cell(30, 10, $lugar['lng'], 1);
    $pdf->Cell(40, 10, "$" . number_format($lugar['costo'], 2), 1);
    $pdf->Ln();
}

// Si viene imagen del mapa (base64)
if (isset($_POST['mapa_base64'])) {
    $imgData = $_POST['mapa_base64'];
    $imgData = str_replace('data:image/png;base64,', '', $imgData);
    $imgData = base64_decode($imgData);

    $imgPath = __DIR__ . '/temp_mapa.png';
    file_put_contents($imgPath, $imgData);

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Mapa del recorrido', 0, 1, 'C');
    $pdf->Image($imgPath, 10, 30, 190);

    // Limpiar archivo temporal si querés
    unlink($imgPath);
}

$pdf->Output('I', 'ruta_personalizada.pdf');
exit;
?>

