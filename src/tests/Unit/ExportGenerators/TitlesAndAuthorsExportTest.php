<?php

namespace Tests\Unit\ExportGenerators;

use Tests\TestCase;
use App\Book;
use App\Author;
use App\ExportGenerators\TitlesAndAuthorsExport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TitlesAndAuthorsExportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function given_books_with_authors_when_toCsv_then_contains_title_and_author()
    {
        // Arrange
        $author = Author::create(['name' => 'Author X']);
        Book::create(['title' => 'Book X', 'author_id' => $author->id]);

        $export = new TitlesAndAuthorsExport();

        // Act
        $csv = $export->toCsv();

        // Assert
        $this->assertStringContainsString('Book X', $csv);
        $this->assertStringContainsString('Author X', $csv);
        $this->assertStringContainsString('Title', $csv);
        $this->assertStringContainsString('Author', $csv);
    }

    /** @test */
    public function given_books_with_authors_when_toXml_then_contains_title_and_author_nodes()
    {
        // Arrange
        $author = Author::create(['name' => 'Author Y']);
        Book::create(['title' => 'Book Y', 'author_id' => $author->id]);

        $export = new TitlesAndAuthorsExport();

        // Act
        $xml = $export->toXml();

        // Assert
        $this->assertStringContainsString('<title>Book Y</title>', $xml);
        $this->assertStringContainsString('<author>Author Y</author>', $xml);
        $this->assertStringContainsString('<?xml', $xml);
    }
}
