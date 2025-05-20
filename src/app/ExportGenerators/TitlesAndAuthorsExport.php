<?php

namespace App\ExportGenerators;

use App\Book;
use App\Contracts\ExportGenerator;

class TitlesAndAuthorsExport implements ExportGenerator
{
    protected $data;

    public function __construct()
    {
        $this->data = Book::with('author')->get(['title', 'author_id']);
    }

    public function toCsv(): string
    {
        $csv = fopen('php://temp', 'r+');
        fputcsv($csv, ['Title', 'Author']);
        foreach ($this->data as $book) {
            fputcsv($csv, [$book->title, $book->author->name]);
        }
        rewind($csv);
        return stream_get_contents($csv);
    }

    public function toXml(): string
    {
        $xml = new \SimpleXMLElement('<export></export>');
        foreach ($this->data as $book) {
            $item = $xml->addChild('book');
            $item->addChild('title', $book->title);
            $item->addChild('author', $book->author->name);
        }
        return $xml->asXML();
    }
}
