<?php

namespace Tests\Unit\ExportGenerators;

use Tests\TestCase;
use App\Author;
use App\ExportGenerators\AuthorsOnlyExport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorsOnlyExportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function given_authors_when_toCsv_then_returns_expected_csv()
    {
        // Arrange
        Author::create(['name' => 'Author One']);
        Author::create(['name' => 'Author Two']);

        $export = new AuthorsOnlyExport();

        // Act
        $csv = $export->toCsv();

        // Assert
        $this->assertStringContainsString('Author', $csv);
        $this->assertStringContainsString('Author One', $csv);
        $this->assertStringContainsString('Author Two', $csv);
    }

    /** @test */
    public function given_authors_when_toXml_then_returns_valid_xml()
    {
        // Arrange
        Author::create(['name' => 'Author A']);
        $export = new AuthorsOnlyExport();

        // Act
        $xml = $export->toXml();

        // Assert
        $this->assertStringContainsString('<author>Author A</author>', $xml);
        $this->assertStringContainsString('<?xml', $xml);
    }
}
