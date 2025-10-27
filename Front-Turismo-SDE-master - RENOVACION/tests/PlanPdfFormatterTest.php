<?php
require __DIR__ . '/../lib/PlanPdfFormatter.php';

$sample = [
    ['nombre' => 'Bañado La Estrella', 'duracion' => 180, 'costo' => 2500.75],
    ['nombre' => 'Termas de Río Hondo', 'duracion' => 120, 'costo' => 1800.00],
];

$dummyLogo = 'data:image/png;base64,AAA=';
$result = plan_pdf_build_content($sample, null, ['logo_data_uri' => $dummyLogo]);

if (strpos($result['html'], 'Bañado La Estrella') === false) {
    fwrite(STDERR, "Falta el destino principal en el HTML\n");
    exit(1);
}
if (strpos($result['html'], '$2,500.75') === false) {
    fwrite(STDERR, "Falta el costo en el HTML\n");
    exit(1);
}
if (strpos($result['html'], $dummyLogo) === false) {
    fwrite(STDERR, "El logo no se insertó en el HTML\n");
    exit(1);
}
if (strpos($result['html'], '<tfoot>') === false) {
    fwrite(STDERR, "La tabla HTML no incluye el pie con totales\n");
    exit(1);
}
if (strpos($result['html'], "font-family:'Calibri'") === false) {
    fwrite(STDERR, "La tabla HTML no aplica el estilo tipo Excel\n");
    exit(1);
}
if (strpos($result['html'], '#1F4E79') === false) {
    fwrite(STDERR, "La cabecera no utiliza el color institucional\n");
    exit(1);
}
if (strpos($result['html'], '#f3f6fb') === false) {
    fwrite(STDERR, "La tabla no alterna el color de las filas\n");
    exit(1);
}

$lineFound = false;
foreach ($result['lines'] as $line) {
    if (strpos($line, 'Bañado La Estrella') !== false) {
        $lineFound = true;
        break;
    }
}
if (!$lineFound) {
    fwrite(STDERR, "No se encontró la fila de la tabla en el PDF simple\n");
    exit(1);
}
$totalRowFound = false;
foreach ($result['lines'] as $line) {
    if (strpos($line, 'TOTAL') !== false && strpos($line, '300') !== false) {
        $totalRowFound = true;
        break;
    }
}
if (!$totalRowFound) {
    fwrite(STDERR, "La tabla en texto no incluye el total calculado\n");
    exit(1);
}
$borderFound = false;
foreach ($result['lines'] as $line) {
    if (strpos($line, '+') === 0 && strpos($line, '=') !== false) {
        $borderFound = true;
        break;
    }
}
if (!$borderFound) {
    fwrite(STDERR, "La versión en texto no refleja los bordes estilo Excel\n");
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
$overrideTotalRowFound = false;
foreach ($override['lines'] as $line) {
    if (strpos($line, 'TOTAL') !== false && strpos($line, '999') !== false && strpos($line, '8,888.50') !== false) {
        $overrideTotalRowFound = true;
        break;
    }
}
if (!$overrideTotalRowFound) {
    fwrite(STDERR, "El override no se reflejó en la tabla en texto plano\n");
    exit(1);
}

echo "PlanPdfFormatterTest OK\n";
