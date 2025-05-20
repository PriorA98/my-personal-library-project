<?php

namespace App\ExportGenerators;

use App\Author;
use App\Contracts\ExportGenerator;

class AuthorsOnlyExport implements ExportGenerator
{
    protected $data;

    public function __construct()
    {
        $this->data = Author::all(['name']);
    }

    public function toCsv(): string
    {
        $csv = fopen('php://temp', 'r+');
        fputcsv($csv, ['Author']);
        foreach ($this->data as $author) {
            fputcsv($csv, [$author->name]);
        }
        rewind($csv);
        return stream_get_contents($csv);
    }

    public function toXml(): string
    {
        $xml = new \SimpleXMLElement('<export></export>');
        foreach ($this->data as $author) {
            $xml->addChild('author', $author->name);
        }
        return $xml->asXML();
    }
}
