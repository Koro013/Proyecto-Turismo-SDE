<?php

declare(strict_types=1);

/**
 * Build both HTML and plain-text lines to describe a travel plan.
 *
 * @param array<int, array{nombre:string,duracion:numeric,costo:numeric}> $destinos
 * @param array{duracion?:numeric,costo?:numeric}|null $totalsOverride
 *
 * @return array{html:string, lines:array<int, string>, totals:array{duracion:int,costo:float}}
 */
function plan_pdf_build_content(array $destinos, ?array $totalsOverride = null): array
{
    $calculatedDur = 0;
    $calculatedCosto = 0.0;

    $rows = [];
    $lines = [];

    foreach ($destinos as $destino) {
        $nombre = (string) ($destino['nombre'] ?? '');
        $duracion = (int) ($destino['duracion'] ?? 0);
        $costo = (float) ($destino['costo'] ?? 0);

        $calculatedDur += $duracion;
        $calculatedCosto += $costo;

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

    $totalDur = (int) round(plan_pdf_select_total($totalsOverride['duracion'] ?? null, $calculatedDur));
    $totalCosto = (float) plan_pdf_select_total($totalsOverride['costo'] ?? null, $calculatedCosto);

    $htmlParts[] = sprintf(
        '<p><strong>Total tiempo:</strong> %d min</p>',
        $totalDur
    );
    $htmlParts[] = sprintf(
        '<p><strong>Total costo:</strong> $%s</p>',
        number_format($totalCosto, 2)
    );

    $lines[] = 'Total tiempo: ' . $totalDur . ' min';
    $lines[] = 'Total costo: $' . number_format($totalCosto, 2);

    return [
        'html' => implode("\n", $htmlParts),
        'lines' => $lines,
        'totals' => [
            'duracion' => $totalDur,
            'costo' => $totalCosto,
        ],
    ];
}

/**
 * Pick a numeric total favouring client-provided overrides when valid.
 *
 * @param numeric|null $override
 * @param numeric $calculated
 *
 * @return float|int
 */
function plan_pdf_select_total($override, $calculated)
{
    if (is_numeric($override)) {
        return $override + 0;
    }

    return $calculated + 0;
}
