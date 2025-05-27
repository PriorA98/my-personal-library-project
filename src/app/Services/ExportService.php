<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class ExportService
{
    private const EXPORT_FOLDER = 'exports';
    private const SUPPORTED_FORMATS = ['csv', 'xml'];

    public function exportDataToFile(string $dataType, string $fileFormat): string
    {
        $this->validateFormat($fileFormat);

        $filePath = $this->buildExportFilePath($fileFormat);
        $content = $this->generateContent($dataType, $fileFormat);

        Storage::put($filePath, $content);

        return $filePath;
    }

    public function generateContent(string $dataType, string $fileFormat): string
    {
        $this->validateFormat($fileFormat);

        $generator = app()->make("export.$dataType");

        switch ($fileFormat) {
            case 'csv':
                return $generator->toCsv();
            case 'xml':
                return $generator->toXml();
            default:
                throw new InvalidArgumentException("Unsupported format: {$fileFormat}");
        }
    }

    protected function buildExportFilePath(string $fileFormat): string
    {
        $timestamp = now()->format('Ymd_His');
        return self::EXPORT_FOLDER . "/export_{$timestamp}.{$fileFormat}";
    }

    protected function validateFormat(string $format): void
    {
        if (!in_array($format, self::SUPPORTED_FORMATS, true)) {
            throw new InvalidArgumentException("Unsupported export format: {$format}");
        }
    }
}
