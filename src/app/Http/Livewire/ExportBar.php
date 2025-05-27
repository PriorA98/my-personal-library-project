<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Enums\ExportType;
use App\Services\ExportService;

class ExportBar extends Component
{
    public $showOptions = false;
    public $selectedType = null;
    public $loading = false;
    public $previewContent = null;
    public $previewFormat = null;

    public function toggleOptions()
    {
        $this->showOptions = !$this->showOptions;
        $this->reset('selectedType', 'previewContent', 'previewFormat', 'loading');
    }

    public function selectType($type)
    {
        if (!ExportType::isValid($type))
            return;

        $this->selectedType = $type;
        $this->reset('previewContent', 'previewFormat');
    }

    public function preview($format)
    {
        if (!in_array($format, ['csv', 'xml']) || !$this->selectedType)
            return;

        $this->loading = true;

        $this->previewContent = app(ExportService::class)
            ->generateContent($this->selectedType, $format);

        $this->previewFormat = $format;
        $this->loading = false;
    }

    public function confirmDownload()
    {
        if (!$this->previewFormat || !$this->selectedType)
            return;

        $path = app(ExportService::class)
            ->exportDataToFile($this->selectedType, $this->previewFormat);

        $this->dispatchBrowserEvent('download-file', [
            'url' => route('exports.download', ['path' => $path])
        ]);

        $this->reset('previewContent', 'previewFormat', 'loading');
    }

    public function cancelPreview()
    {
        $this->reset('previewContent', 'previewFormat', 'loading');
    }

    public function render()
    {
        return view('livewire.export-bar');
    }
}
