<?php

namespace App\ExportGenerators;

use App\Book;
use App\Contracts\ExportGenerator;

class TitlesOnlyExport implements ExportGenerator
{
    protected $data;

    public function __construct()
    {
        $this->data = Book::all(['title']);
    }

    public function toCsv(): string
    {
        $csv = fopen('php://temp', 'r+');
        fputcsv($csv, ['Title']);
        foreach ($this->data as $book) {
            fputcsv($csv, [$book->title]);
        }
        rewind($csv);
        return stream_get_contents($csv);
    }

    public function toXml(): string
    {
        $xml = new \SimpleXMLElement('<export></export>');
        foreach ($this->data as $book) {
            $xml->addChild('title', $book->title);
        }
        return $xml->asXML();
    }
}
