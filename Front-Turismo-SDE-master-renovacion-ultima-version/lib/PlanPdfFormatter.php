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

    $tableStyles = [
        'table' => 'width:100%; border-collapse:collapse; border:1px solid #9cb6d8;'
            . ' font-family:\'Calibri\', \'Arial\', sans-serif; font-size:14px; background-color:#ffffff;',
        'header' => 'background-color:#1F4E79; color:#ffffff; text-transform:uppercase;'
            . ' border:1px solid #9cb6d8; padding:8px 6px; text-align:left; letter-spacing:0.5px;',
        'cell_left' => 'border:1px solid #9cb6d8; padding:8px 6px; text-align:left; color:#1f1f1f;',
        'cell_right' => 'border:1px solid #9cb6d8; padding:8px 6px; text-align:right; color:#1f1f1f;',
        'total_row' => 'background-color:#d9e1f2; font-weight:700; color:#1f1f1f;',
    ];

    foreach ($destinos as $index => $destino) {
        $nombre = (string) ($destino['nombre'] ?? '');
        $duracion = (int) ($destino['duracion'] ?? 0);
        $costo = (float) ($destino['costo'] ?? 0);

        $calculatedDur += $duracion;
        $calculatedCosto += $costo;

        $rowShade = ($index % 2 === 0) ? '#ffffff' : '#f3f6fb';

        $rows[] = sprintf(
            '<tr style="background-color:%s;">'
            . '<td style="%s">%s</td>'
            . '<td style="%s">%d</td>'
            . '<td style="%s">$%s</td>'
            . '</tr>',
            $rowShade,
            $tableStyles['cell_left'],
            htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'),
            $tableStyles['cell_right'],
            $duracion,
            $tableStyles['cell_right'],
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
        $htmlParts[] = '<table style="' . $tableStyles['table'] . '">';
        $htmlParts[] = '<thead>'
            . '<tr>'
            . '<th style="' . $tableStyles['header'] . '">Destino</th>'
            . '<th style="' . $tableStyles['header'] . '; text-align:center;">Duración (min)</th>'
            . '<th style="' . $tableStyles['header'] . '; text-align:center;">Costo</th>'
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
        $htmlParts[] = '<tr style="' . $tableStyles['total_row'] . '">'
            . '<td style="' . $tableStyles['cell_left'] . ' font-weight:inherit;">Total</td>'
            . '<td style="' . $tableStyles['cell_right'] . ' font-weight:inherit;">' . $totalDur . '</td>'
            . '<td style="' . $tableStyles['cell_right'] . ' font-weight:inherit;">$' . number_format($totalCosto, 2) . '</td>'
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

    $rowBorder = '+' . str_repeat('-', $nameWidth + 2)
        . '+' . str_repeat('-', $durWidth + 2)
        . '+' . str_repeat('-', $costoWidth + 2)
        . '+';
    $headerBorder = '+' . str_repeat('=', $nameWidth + 2)
        . '+' . str_repeat('=', $durWidth + 2)
        . '+' . str_repeat('=', $costoWidth + 2)
        . '+';

    $lines = [];
    $lines[] = $rowBorder;
    $lines[] = plan_pdf_ascii_row($headers['nombre'], $headers['duracion'], $headers['costo'], $nameWidth, $durWidth, $costoWidth);
    $lines[] = $headerBorder;

    $lastIndex = count($rows) - 1;
    foreach ($rows as $idx => $row) {
        $lines[] = plan_pdf_ascii_row($row['nombre'], (string) $row['duracion'], $row['costo'], $nameWidth, $durWidth, $costoWidth);
        if ($idx < $lastIndex) {
            $lines[] = $rowBorder;
        }
    }

    $lines[] = $headerBorder;
    $lines[] = plan_pdf_ascii_row('TOTAL', $totalDurStr, $totalCostStr, $nameWidth, $durWidth, $costoWidth);
    $lines[] = $rowBorder;

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

function plan_pdf_ascii_row(string $nombre, string $duracion, string $costo, int $nameWidth, int $durWidth, int $costoWidth): string
{
    return '| ' . plan_pdf_pad_right($nombre, $nameWidth)
        . ' | ' . plan_pdf_pad_left($duracion, $durWidth)
        . ' | ' . plan_pdf_pad_left($costo, $costoWidth)
        . ' |';
}
