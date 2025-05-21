<?php

namespace Tests\Controllers;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class ExportDownloadControllerTest extends TestCase
{
    /** @test */
    public function given_existing_file_when_requesting_download_then_returns_file_and_deletes_it()
    {
        // Arrange
        Storage::fake();
        $path = 'exports/test-export.csv';
        $content = 'title,author';
        Storage::put($path, $content);

        // Act
        $response = $this->get('/exports/download?path=' . urlencode($path));

        // Assert
        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->assertHeader('Content-Disposition', 'attachment; filename="test-export.csv"');
        $response->assertSee($content);
        Storage::assertMissing($path);
    }

    /** @test */
    public function given_nonexistent_file_when_requesting_download_then_returns_404()
    {
        // Act
        $response = $this->get('/exports/download?path=exports/missing.csv');

        // Assert
        $response->assertStatus(404);
    }

    /** @test */
    public function given_xml_file_when_requesting_download_then_sets_correct_mime_type()
    {
        // Arrange
        Storage::fake();
        $path = 'exports/data.xml';
        Storage::put($path, '<export/>');

        // Act
        $response = $this->get('/exports/download?path=' . urlencode($path));

        // Assert
        $response->assertHeader('Content-Type', 'application/xml');
        Storage::assertMissing($path);
    }
}
