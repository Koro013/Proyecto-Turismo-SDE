<?php

declare(strict_types=1);

/**
 * Build both HTML and plain-text lines to describe a travel plan.
 *
 * @param array<int, array{nombre:string,duracion:numeric,costo:numeric}> $destinos
 * @return array{html:string, lines:array<int, string>}
 */
function plan_pdf_build_content(array $destinos): array
{
    $totalDur = 0;
    $totalCosto = 0.0;

    $rows = [];
    $lines = [];

    foreach ($destinos as $destino) {
        $nombre = (string) ($destino['nombre'] ?? '');
        $duracion = (int) ($destino['duracion'] ?? 0);
        $costo = (float) ($destino['costo'] ?? 0);

        $totalDur += $duracion;
        $totalCosto += $costo;

        $rows[] = sprintf(
            '<tr>'
            . '<td style="padding:6px 4px;">%s</td>'
            . '<td style="padding:6px 4px; text-align:right;">%d</td>'
            . '<td style="padding:6px 4px; text-align:right;">$%s</td>'
            . '</tr>',
            htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'),
            $duracion,
            number_format($costo, 2)
        );

        $lines[] = $nombre;
        $lines[] = '  Duración: ' . $duracion . ' min';
        $lines[] = '  Costo: $' . number_format($costo, 2);
        $lines[] = '';
    }

    $htmlParts = [];
    $htmlParts[] = '<h1 style="text-align:center;">Plan de Viaje</h1>';

    if (!empty($rows)) {
        $htmlParts[] = '<table style="width:100%; border-collapse:collapse;">';
        $htmlParts[] = '<thead>'
            . '<tr>'
            . '<th style="text-align:left; border-bottom:1px solid #ccc; padding:8px 4px;">Destino</th>'
            . '<th style="text-align:right; border-bottom:1px solid #ccc; padding:8px 4px;">Duración (min)</th>'
            . '<th style="text-align:right; border-bottom:1px solid #ccc; padding:8px 4px;">Costo</th>'
            . '</tr>'
            . '</thead>';
        $htmlParts[] = '<tbody>';
        foreach ($rows as $row) {
            $htmlParts[] = $row;
        }
        $htmlParts[] = '</tbody>';
        $htmlParts[] = '</table>';
    } else {
        $htmlParts[] = '<p>No se seleccionaron destinos.</p>';
    }

    $htmlParts[] = sprintf(
        '<p><strong>Total tiempo:</strong> %d min</p>',
        (int) $totalDur
    );
    $htmlParts[] = sprintf(
        '<p><strong>Total costo:</strong> $%s</p>',
        number_format($totalCosto, 2)
    );

    $lines[] = 'Total tiempo: ' . (int) $totalDur . ' min';
    $lines[] = 'Total costo: $' . number_format($totalCosto, 2);

    return [
        'html' => implode("\n", $htmlParts),
        'lines' => $lines,
    ];
}
