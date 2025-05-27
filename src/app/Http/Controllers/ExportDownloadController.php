<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ExportDownloadController extends Controller
{
    public function __invoke()
    {
        $path = request('path');
        abort_unless(Storage::exists($path), 404);

        $content = Storage::get($path);
        Storage::delete($path);

        return response($content)
            ->header('Content-Type', $this->getMimeType($path))
            ->header('Content-Disposition', 'attachment; filename="' . basename($path) . '"');
    }

    private function getMimeType($path)
    {
        return substr($path, -4) === '.xml' ? 'application/xml' : 'text/csv';
    }
}
