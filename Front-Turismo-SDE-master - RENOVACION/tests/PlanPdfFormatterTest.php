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

if ($result['totals']['duracion'] !== 300) {
    fwrite(STDERR, "El total de duración calculado es incorrecto\n");
    exit(1);
}
if (abs($result['totals']['costo'] - 4300.75) > 0.001) {
    fwrite(STDERR, "El total de costo calculado es incorrecto\n");
    exit(1);
}

$override = plan_pdf_build_content($sample, ['duracion' => '999', 'costo' => '8888.5']);
if ($override['totals']['duracion'] !== 999) {
    fwrite(STDERR, "El total de duración no respeta el override del cliente\n");
    exit(1);
}
if (abs($override['totals']['costo'] - 8888.5) > 0.001) {
    fwrite(STDERR, "El total de costo no respeta el override del cliente\n");
    exit(1);
}

$overrideLine = 'Total tiempo: 999 min';
if (!in_array($overrideLine, $override['lines'], true)) {
    fwrite(STDERR, "Las líneas no se actualizaron con el override del cliente\n");
    exit(1);
}

echo "PlanPdfFormatterTest OK\n";
