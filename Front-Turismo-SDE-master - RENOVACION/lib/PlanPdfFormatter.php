<?php

declare(strict_types=1);

/**
 * Build both HTML and plain-text lines to describe a travel plan.
 *
 * @param array<int, array{nombre:string,duracion:numeric,costo:numeric}> $destinos
 * @param array{duracion?:numeric,costo?:numeric}|null $totalsOverride
 * @param array{logo_data_uri?:string}|null $options
 *
 * @return array{html:string, lines:array<int, string>, totals:array{duracion:int,costo:float}}
 */
function plan_pdf_build_content(array $destinos, ?array $totalsOverride = null, ?array $options = null): array
{
    $options = $options ?? [];
    $calculatedDur = 0;
    $calculatedCosto = 0.0;

    $rows = [];
    $tableMatrix = [];

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
        $tableMatrix[] = [
            'nombre' => $nombre,
            'duracion' => $duracion,
            'costo' => '$' . number_format($costo, 2),
        ];
    }

    $htmlParts = [];
    $logoDataUri = $options['logo_data_uri'] ?? null;
    if (is_string($logoDataUri) && $logoDataUri !== '') {
        $htmlParts[] = '<div style="text-align:center; margin-bottom:16px;">'
            . '<img src="' . htmlspecialchars($logoDataUri, ENT_QUOTES, 'UTF-8')
            . '" alt="Logo Santiago del Estero" style="max-height:80px;">'
            . '</div>';
    }
    $htmlParts[] = '<h1 style="text-align:center;">Plan de Viaje</h1>';

    if (!empty($rows)) {
        $htmlParts[] = '<table style="width:100%; border-collapse:collapse; border:1px solid #ddd;">';
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
    } else {
        $htmlParts[] = '<p>No se seleccionaron destinos.</p>';
    }

    $totalDur = (int) round(plan_pdf_select_total($totalsOverride['duracion'] ?? null, $calculatedDur));
    $totalCosto = (float) plan_pdf_select_total($totalsOverride['costo'] ?? null, $calculatedCosto);

    if (!empty($rows)) {
        $htmlParts[] = '<tfoot>';
        $htmlParts[] = '<tr>'
            . '<td style="padding:8px 4px; text-align:left; font-weight:bold; border-top:1px solid #ccc;">Total</td>'
            . '<td style="padding:8px 4px; text-align:right; font-weight:bold; border-top:1px solid #ccc;">' . $totalDur . '</td>'
            . '<td style="padding:8px 4px; text-align:right; font-weight:bold; border-top:1px solid #ccc;">$' . number_format($totalCosto, 2) . '</td>'
            . '</tr>';
        $htmlParts[] = '</tfoot>';
        $htmlParts[] = '</table>';
    }

    $htmlParts[] = sprintf(
        '<p><strong>Total tiempo:</strong> %d min</p>',
        $totalDur
    );
    $htmlParts[] = sprintf(
        '<p><strong>Total costo:</strong> $%s</p>',
        number_format($totalCosto, 2)
    );

    $lines = plan_pdf_build_ascii_table($tableMatrix, $totalDur, $totalCosto);
    if (empty($lines)) {
        $lines[] = 'No se seleccionaron destinos.';
    }
    $lines[] = '';
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

/**
 * @param array<int, array{nombre:string,duracion:int,costo:string}> $rows
 * @return array<int, string>
 */
function plan_pdf_build_ascii_table(array $rows, int $totalDur, float $totalCosto): array
{
    if (empty($rows)) {
        return [];
    }

    $headers = [
        'nombre' => 'Destino',
        'duracion' => 'Duración (min)',
        'costo' => 'Costo',
    ];

    $nameWidth = plan_pdf_measure_width($headers['nombre']);
    $durWidth = plan_pdf_measure_width($headers['duracion']);
    $costoWidth = plan_pdf_measure_width($headers['costo']);

    foreach ($rows as $row) {
        $nameWidth = max($nameWidth, plan_pdf_measure_width($row['nombre']));
        $durWidth = max($durWidth, plan_pdf_measure_width((string) $row['duracion']));
        $costoWidth = max($costoWidth, plan_pdf_measure_width($row['costo']));
    }

    $totalDurStr = (string) $totalDur;
    $totalCostStr = '$' . number_format($totalCosto, 2);
    $nameWidth = max($nameWidth, plan_pdf_measure_width('TOTAL'));
    $durWidth = max($durWidth, plan_pdf_measure_width($totalDurStr));
    $costoWidth = max($costoWidth, plan_pdf_measure_width($totalCostStr));

    $separator = str_repeat('-', $nameWidth) . '-+-' . str_repeat('-', $durWidth) . '-+-' . str_repeat('-', $costoWidth);

    $lines = [];
    $lines[] = plan_pdf_pad_right($headers['nombre'], $nameWidth)
        . ' | ' . plan_pdf_pad_left($headers['duracion'], $durWidth)
        . ' | ' . plan_pdf_pad_left($headers['costo'], $costoWidth);
    $lines[] = $separator;

    foreach ($rows as $row) {
        $lines[] = plan_pdf_pad_right($row['nombre'], $nameWidth)
            . ' | ' . plan_pdf_pad_left((string) $row['duracion'], $durWidth)
            . ' | ' . plan_pdf_pad_left($row['costo'], $costoWidth);
    }

    $lines[] = $separator;
    $lines[] = plan_pdf_pad_right('TOTAL', $nameWidth)
        . ' | ' . plan_pdf_pad_left($totalDurStr, $durWidth)
        . ' | ' . plan_pdf_pad_left($totalCostStr, $costoWidth);

    return $lines;
}

function plan_pdf_measure_width(string $value): int
{
    if (function_exists('mb_strwidth')) {
        return mb_strwidth($value, 'UTF-8');
    }

    return strlen($value);
}

function plan_pdf_pad_right(string $value, int $width): string
{
    $padding = $width - plan_pdf_measure_width($value);
    if ($padding > 0) {
        return $value . str_repeat(' ', $padding);
    }

    return $value;
}

function plan_pdf_pad_left(string $value, int $width): string
{
    $padding = $width - plan_pdf_measure_width($value);
    if ($padding > 0) {
        return str_repeat(' ', $padding) . $value;
    }

    return $value;
}
