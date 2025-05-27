<?php

namespace Tests\Unit\ExportGenerators;

use Tests\TestCase;
use App\Book;
use App\Author;
use App\ExportGenerators\TitlesOnlyExport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TitlesOnlyExportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function given_books_when_toCsv_then_returns_expected_csv()
    {
        // Arrange
        $author = Author::create(['name' => 'Author']);
        Book::create(['title' => 'Book A', 'author_id' => $author->id]);
        Book::create(['title' => 'Book B', 'author_id' => $author->id]);

        $export = new TitlesOnlyExport();

        // Act
        $csv = $export->toCsv();

        // Assert
        $this->assertStringContainsString('Book A', $csv);
        $this->assertStringContainsString('Book B', $csv);
        $this->assertStringContainsString('Title', $csv);
    }

    /** @test */
    public function given_books_when_toXml_then_returns_valid_xml()
    {
        // Arrange
        $author = Author::create(['name' => 'Author']);
        Book::create(['title' => 'XML Book', 'author_id' => $author->id]);
        $export = new TitlesOnlyExport();

        // Act
        $xml = $export->toXml();

        // Assert
        $this->assertStringContainsString('<title>XML Book</title>', $xml);
        $this->assertStringContainsString('<?xml', $xml);
    }
}
