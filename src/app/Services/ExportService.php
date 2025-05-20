<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Contracts\ExportGenerator;

class ExportService
{
    public function generateSingle(string $type, string $format): string
    {
        $timestamp = now()->format('Ymd_His');
        $filename = "exports/export_{$timestamp}.{$format}";
        $generator = app("export.$type");

        $content = $format === 'csv' ? $generator->toCsv() : $generator->toXml();
        Storage::put($filename, $content);

        return $filename;
    }
}
