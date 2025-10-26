<?php
require __DIR__ . '/../lib/PlanPdfFormatter.php';

$sample = [
    ['nombre' => 'Bañado La Estrella', 'duracion' => 180, 'costo' => 2500.75],
    ['nombre' => 'Termas de Río Hondo', 'duracion' => 120, 'costo' => 1800.00],
];

$result = plan_pdf_build_content($sample);

if (strpos($result['html'], 'Bañado La Estrella') === false) {
    fwrite(STDERR, "Falta el destino principal en el HTML\n");
    exit(1);
}
if (strpos($result['html'], '$2,500.75') === false) {
    fwrite(STDERR, "Falta el costo en el HTML\n");
    exit(1);
}

$expectedLine = '  Costo: $2,500.75';
if (!in_array($expectedLine, $result['lines'], true)) {
    fwrite(STDERR, "No se encontró la línea esperada en el PDF simple: {$expectedLine}\n");
    exit(1);
}

echo "PlanPdfFormatterTest OK\n";
