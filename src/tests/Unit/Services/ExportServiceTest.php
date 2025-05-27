<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;

class ExportServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ExportService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ExportService();

        Storage::fake();
    }

    /** @test */
    public function given_csv_format_when_exportDataToFile_then_file_is_saved_and_path_is_returned()
    {
        // Arrange
        $this->bindFakeExportGenerator();

        // Act
        $path = $this->service->exportDataToFile('titles', 'csv');

        // Assert
        Storage::assertExists($path);
        $this->assertStringEndsWith('.csv', $path);
    }

    /** @test */
    public function given_xml_format_when_generateContent_then_returns_xml_string()
    {
        // Arrange
        $this->bindFakeExportGenerator();

        // Act
        $xml = $this->service->generateContent('titles', 'xml');

        // Assert
        $this->assertStringContainsString('<title>X</title>', $xml);
    }


    /** @test */
    public function given_unsupported_format_when_exportDataToFile_then_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->service->exportDataToFile('titles', 'unsupported_format');
    }

    /** @test */
    public function given_unsupported_format_when_generateContent_then_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->service->generateContent('titles', 'unsupported_format');
    }

    /** @test */
    public function given_valid_format_when_buildExportFilePath_then_returns_expected_path()
    {
        // Act
        $path = (new \ReflectionClass($this->service))
            ->getMethod('buildExportFilePath');
        $path->setAccessible(true);

        $result = $path->invoke($this->service, 'csv');

        // Assert
        $this->assertRegExp('/exports\/export_\d{8}_\d{6}\.csv/', $result);
    }

    protected function bindFakeExportGenerator(): void
    {
        App::bind("export.titles", fn() => new class (['csv' => 'title1', 'xml' => '<export><title>X</title></export>',]) {
            protected $data;

            public function __construct($data)
                {
                    $this->data = $data;
                }

                public function toCsv()
                {
                    return $this->data['csv'];
                }

                public function toXml()
                {
                    return $this->data['xml'];
                }
            });
    }

}
