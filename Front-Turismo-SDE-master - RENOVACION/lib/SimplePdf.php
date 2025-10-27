<?php

function simple_pdf_escape_text(string $text): string
{
    if (function_exists('mb_convert_encoding')) {
        $converted = @mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
    } else {
        $converted = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
    }

    if ($converted !== false && $converted !== null) {
        $text = $converted;
    }

    return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
}

function simple_pdf_join(array $parts): string
{
    return implode("\r\n", $parts) . "\r\n";
}

function simple_pdf_build_document(string $title, array $lines): string
{
    $streamParts = [];
    $streamParts[] = 'BT';
    $streamParts[] = '/F1 18 Tf';
    $streamParts[] = '72 770 Td';
    $streamParts[] = '(' . simple_pdf_escape_text($title) . ') Tj';

    if (!empty($lines)) {
        $streamParts[] = '/F1 12 Tf';
        $streamParts[] = '0 -28 Td';
        $firstLine = true;
        foreach ($lines as $line) {
            $lineText = '(' . simple_pdf_escape_text($line) . ') Tj';
            if ($firstLine) {
                $streamParts[] = $lineText;
                $firstLine = false;
            } else {
                $streamParts[] = '0 -16 Td';
                $streamParts[] = $lineText;
            }
        }
    }

    $streamParts[] = 'ET';
    $stream = simple_pdf_join($streamParts);

    $objects = [];
    $objects[] = '<< /Type /Catalog /Pages 2 0 R >>';
    $objects[] = '<< /Type /Pages /Kids [3 0 R] /Count 1 >>';
    $objects[] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>';
    $objects[] = '<< /Length ' . strlen($stream) . ' >>' . "\r\nstream\r\n" . $stream . 'endstream';
    $objects[] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';

    $pdf = "%PDF-1.4\r\n";
    $offsets = [0];
    foreach ($objects as $index => $object) {
        $offsets[$index + 1] = strlen($pdf);
        $pdf .= ($index + 1) . " 0 obj\r\n";
        $pdf .= $object . "\r\n";
        $pdf .= "endobj\r\n";
    }

    $xrefPosition = strlen($pdf);
    $pdf .= 'xref' . "\r\n";
    $pdf .= '0 ' . (count($objects) + 1) . "\r\n";
    $pdf .= '0000000000 65535 f ' . "\r\n";
    for ($i = 1; $i <= count($objects); $i++) {
        $pdf .= sprintf('%010d 00000 n ', $offsets[$i]) . "\r\n";
    }

    $pdf .= 'trailer' . "\r\n";
    $pdf .= '<< /Size ' . (count($objects) + 1) . ' /Root 1 0 R >>' . "\r\n";
    $pdf .= 'startxref' . "\r\n";
    $pdf .= $xrefPosition . "\r\n";
    $pdf .= '%%EOF' . "\r\n";

    return $pdf;
}

function simple_pdf_output(string $title, array $lines, string $filename = 'document.pdf'): void
{
    $pdf = simple_pdf_build_document($title, $lines);
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . strlen($pdf));
    echo $pdf;
}
