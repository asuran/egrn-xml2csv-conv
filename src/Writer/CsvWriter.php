<?php

namespace EgrnXml2CsvConv\Writer;

final class CsvWriter
{
    public static function writeRow(string $filename, array $row): void
    {
        $resource = fopen($filename, 'ab');
        fputcsv($resource, $row);
        fclose($resource);
    }
}
