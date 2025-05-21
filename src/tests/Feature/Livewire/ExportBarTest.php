<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use App\Services\ExportService;

class ExportBarTest extends TestCase
{
    /** @test */
    public function given_initial_state_when_toggleOptions_then_showOptions_toggles_and_state_resets()
    {
        Livewire::test('export-bar')
            ->call('toggleOptions')
            ->assertSet('showOptions', true)
            ->assertSet('selectedType', null)
            ->assertSet('previewContent', null)
            ->assertSet('previewFormat', null);
    }

    /** @test */
    public function given_valid_type_when_selectType_then_type_is_selected_and_preview_resets()
    {
        Livewire::test('export-bar')
            ->call('selectType', 'titles')
            ->assertSet('selectedType', 'titles')
            ->assertSet('previewContent', null)
            ->assertSet('previewFormat', null);
    }

    /** @test */
    public function given_invalid_type_when_selectType_then_state_is_unchanged()
    {
        Livewire::test('export-bar')
            ->set('selectedType', 'authors')
            ->call('selectType', 'invalid')
            ->assertSet('selectedType', 'authors'); // unchanged
    }

    /** @test */
    public function given_selected_type_when_preview_csv_then_previewContent_is_set()
    {
        $this->mockExportServiceReturning('CSV DATA');

        Livewire::test('export-bar')
            ->set('selectedType', 'titles')
            ->call('preview', 'csv')
            ->assertSet('previewContent', 'CSV DATA')
            ->assertSet('previewFormat', 'csv');
    }

    /** @test */
    public function given_state_when_confirmDownload_then_event_dispatched_and_state_reset()
    {
        Event::fake();
        $this->mockExportServiceExportPath('exports/export.csv');

        Livewire::test('export-bar')
            ->set('selectedType', 'titles')
            ->set('previewFormat', 'csv')
            ->call('confirmDownload')
            ->assertDispatchedBrowserEvent('download-file')
            ->assertSet('previewContent', null)
            ->assertSet('previewFormat', null);
    }

    private function mockExportServiceReturning(string $data): void
    {
        App::bind(ExportService::class, function () use ($data) {
            return new class ($data) {
                private $data;
                public function __construct($data)
                {
                    $this->data = $data;
                }
                public function generateContent($type, $format)
                {
                    return $this->data;
                }
            };
        });
    }

    private function mockExportServiceExportPath(string $path): void
    {
        App::bind(ExportService::class, function () use ($path) {
            return new class ($path) {
                private $path;
                public function __construct($path)
                {
                    $this->path = $path;
                }
                public function exportDataToFile($type, $format)
                {
                    return $this->path;
                }
            };
        });
    }
}
